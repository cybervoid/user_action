<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Lookup;
use App\Services\Mailer;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;


class SeparationController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | newHire Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return \App\Http\Controllers\separationController
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the new hire form
     *
     * @return Response
     */
    public function index()
    {

        $user = User::current();

        return view('separation', ['user' => $user]);

    }


    public function add(Request $req)
    {
        $REPORT_TYPE = 'change_org';

        $name = trim($req->request->get('name'));
        $lastName = trim($req->request->get('lastName'));


        // generate separation report
        $separationReport = \Config::get('app.separationReportsPrefix') . $name . ' ' . $lastName . '.pdf';
        $separationReport = Reports::escapeReportName($separationReport);
        $view['sep'] = $req->request->all();
        $view['url'] = $req->url();
        Reports::generateReport($separationReport, \Config::get('app.separationReportsPath'), $req->request->get('reportType'), $view);

        // generate payroll separtion report
        $payrollSeparationReport = \Config::get('app.payrollSeparationReportsPrefix') . $name . ' ' . $lastName . '.pdf';
        $payrollSeparationReport = Reports::escapeReportName($payrollSeparationReport);
        Reports::generateReport($payrollSeparationReport, \Config::get('app.payrollSeparationReportsPath'), 'payroll_separation', $view);


        //send the email
        $to = \Config::get('app.servicedesk');
        $mailNotifyDepartments = [];

        $mailNotifyDepartments[] = $req->request->get('company');
        if ($req->request->get('application') != '')
        {
            $mailNotifyDepartments[] = 'application';
        }
        if ($req->request->get('oManager') != '')
        {
            $mailNotifyDepartments[] = 'management';
        }
        if ($req->request->get('creditCard') != '')
        {
            $mailNotifyDepartments[] = 'creditCard';
        }
        if ($req->request->get('newDriver') != '')
        {
            $mailNotifyDepartments[] = 'newDriver';
        }
        if ($req->request->get('department') == 'Sales' && $req->request->get('company') == 'illy caffè North America, Inc')
        {
            $mailNotifyDepartments[] = 'sales';
        }

        $ccRecipients = MyMail::getRecipients('separation', $mailNotifyDepartments, $req->request->get('managerEmail'));
        $subject = \Config::get('app.subjectPrefix') . $name . ' ' . $lastName;
        $attachment = \Config::get('app.separationReportsPath') . $separationReport;
        $attachment = isset($attachment) ? file_exists($attachment) ? $attachment : false : null;

        Mailer::send('emails.forms', [], function (Message $m) use ($to, $ccRecipients, $subject, $attachment)
        {
            $m->to($to, null)->subject($subject)->cc($ccRecipients);
            if ($attachment)
            {
                $m->attach($attachment);
            }
        });


        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique(array_map("StrToLower", $ccRecipients));

        // execute proper actions for a separation or schedule one
        $today = date('m/d/Y');
        $userName = $req->request->get('sAMAccountName');
        $disableUser = $req->request->get('disableUser');
        $removeGroups = $req->request->get('iTDeptEmail');

        // make translation for JDE and the application team
        if ($req->request->get('application') != '')
        {
            $removeGroups[] = 'JDE USA Remote';
        }

        //if the user is deactivated remove from the default groups
        if ($req->request->get('disableUser') != '')
        {
            $removeGroups[] = 'VPN_usa';
            $removeGroups[] = 'WIFI_usa';
        }


        if (strtotime($today) >= strtotime($req->request->get('termDate')) && $req->request->get('disableNow') == '')
        {
            echo 'due today';
            //remove user from groups

            $ad = ActiveDirectory::get_connection();
            $user_ad_info = $ad->getsamaccountname($req->request->get('sAMAccountName'));


            $ad->removeFromGroups($removeGroups, $user_ad_info[0]["dn"], $disableUser);

            //check if the user wants to disable AD user
            if (isset($disableUser))
            {
                $ad->disableUser($user_ad_info);
                $ad->removeUserInfo($user_ad_info);
            }
        }
        else
        {
            echo 'to schedule';
            // if the separation date is not today, schedule when it will be effective
            Schedule::addSchedule($req->request->get('termDate'), $userName, $name . ' ' . $lastName, 'separation', isset($disableUser), \Config::get('app.separationReportsPath') . $separationReport, $removeGroups);
        }

        // add new entry to the schedule system with due date 6 month after effective date for AD deletion
        $dueDate = date('m/d/Y', strtotime('+6 month', strtotime($req->request->get('termDate'))));

        Schedule::addSchedule($dueDate, $userName, $name . ' ' . $lastName, 'separation_reminder', $req->request->get('termDate'), \Config::get('app.separationReportsPath') . $separationReport, $req->request->get('generalComments'));


        return view('thankYou', ['name' => $name, 'lastName' => $lastName, 'separationReport' => $separationReport,
            'reportType' => 'separation', 'separationRouteURL' => \Config::get('app.separationURL'),
            'sendMail' => $ccRecipients, 'payrollSeparationReport' => $payrollSeparationReport,
            'payrollSeparationRouteURL' => \Config::get('app.payrollSeparationURL'), 'menu_Home' => '',
            'menu_Separation' => '']);

    }


    public function separation_search(Request $req)
    {
        // get AD information
        $result_array['fromAD'] = Lookup::lookupUser($req);
        $result_array['hireStatus'] = \Config::get('app.hireStatus');
        $result_array['payrollType'] = \Config::get('app.payrollType');

        return new Response(json_encode($result_array), 200, ['Content-Type' => 'application/json']);
    }
}
