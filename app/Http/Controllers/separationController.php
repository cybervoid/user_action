<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Mailer;
use Illuminate\Mail\Message;
use App\Services\Lookup;


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
        $ccRecipients = MyMail::emailRecipients($req);
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

        if ((strtotime($today) >= strtotime($req->request->get('termDate'))))
        {
            //remove user from groups

            $ad = ActiveDirectory::get_connection();
            $user_ad_info = $ad->getsamaccountname($req->request->get('sAMAccountName'));

            $ad->removeFromGroups($req->request->get('iTDeptEmail'), $user_ad_info[0]["dn"], $disableUser);

            //check if the user wants to disable AD user
            if (isset($disableUser))
            {
                $ad->disableUser($user_ad_info);
                $ad->removeUserInfo($user_ad_info);
            }
        }
        else
        {
            // if the separation date is not today, schedule when it will be effective
            Schedule::addSchedule($req->request->get('termDate'), $userName, $name . ' ' . $lastName, 'separation', isset($disableUser), \Config::get('app.separationReportsPath') . $separationReport, $req->request->get('iTDeptEmail'));
        }

        // add new entry to the schedule system with due date 6 month after effective date for AD deletion
        $dueDate = date('m/d/Y', strtotime('+6 month', strtotime($req->request->get('termDate'))));

        Schedule::addSchedule($dueDate, $userName, $name . ' ' . $lastName, 'separation_reminder', $req->request->get('termDate'), \Config::get('app.separationReportsPath') . $separationReport, $req->request->get('generalComments'));


        return view('thankYou', ['name' => $name, 'lastName' => $lastName,
            'separationReport' => $separationReport, 'reportType' => 'separation',
            'separationRouteURL' => \Config::get('app.separationURL'), 'sendMail' => $ccRecipients,
            'payrollSeparationReport' => $payrollSeparationReport,
            'payrollSeparationRouteURL' => \Config::get('app.payrollSeparationURL'), 'menu_Home' => '',
            'menu_Separation' => '']);

    }


    public function separation_search(Request $req)
    {

        // get AD information
        $result_array['fromAD'] = Lookup::lookupUser($req);
        $result_array['hireStatus'] = \Config::get('app.hireStatus');
        return new Response(json_encode($result_array), 200, ['Content-Type' => 'application/json']);

    }
}
