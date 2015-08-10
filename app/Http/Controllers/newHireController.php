<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Mailer;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;


class newHireController extends Controller
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
     * @return \App\Http\Controllers\newHireController
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

        return view('newHire', ['user' => $user]);

    }


    /**
     * New request is created, create the report and show the welcome page
     *
     * @param Request $req
     *
     * @return \Illuminate\View\View
     */
    public function add(Request $req)
    {

        $name = trim($req->request->get('name'));
        $lastName = trim($req->request->get('lastName'));

        // generate newHire reports
        $newHireReport = \Config::get('app.newHireReportsPrefix') . $name . ' ' . $lastName . '.pdf';
        $newHireReport = Reports::escapeReportName($newHireReport);
        $result = Reports::generateReport($newHireReport, \Config::get('app.newHireReportsPath'), $req->request->get('reportType'), $req);


        //generate payroll Report
        $payrollReport = \Config::get('app.payrollReportsPrefix') . $name . ' ' . $lastName . '.pdf';
        $payrollReport = Reports::escapeReportName($payrollReport);
        Reports::generateReport($payrollReport, \Config::get('app.payrollReportsPath'), 'payroll', $req);

        //send the email
        $to = \Config::get('app.servicedesk');
        $ccRecipients = MyMail::emailRecipients($req);
        $subject = \Config::get('app.subjectPrefix') . $name . ' ' . $lastName;

        $attachment = \Config::get('app.newHireReportsPath') . $newHireReport;
        $attachment = isset($attachment) ? file_exists($attachment) ? $attachment : false : null;

        if (env('APP_STATUS') != 'offline')
        {
            Mailer::send('emails.forms', [], function (Message $m) use ($to, $ccRecipients, $subject, $attachment)
            {
                $m->to($to, null)->subject($subject);
                $m->cc($ccRecipients);

                if ($attachment)
                {
                    $m->attach($attachment);
                }
            });
        }


        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique($ccRecipients);


        $illyGroups['illyusaNorth America'] = 'CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyryebrook'] = 'CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyusa NYC Team'] = 'CN=illy NYC Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyCanada'] = 'CN=illy Canada Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyManagers'] = 'CN=illyusa Managers Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illySales'] = 'CN=illyusa Sales Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';

        if (env('APP_STATUS') == 'offline')
        {
            $groupsToAdd = $req->request->get('iTDeptEmail');
            if (isset($groupsToAdd))
            {
                foreach ($groupsToAdd as $group)
                {
                    $groups[] = $illyGroups[$group];
                }
            }
        }


        $samaacountname = strtolower(substr($lastName, 0, 5) . substr($name, 0, 2));

        if (env('APP_STATUS') != 'offline')
        {
            //send request to si_infra to add the user to VPN and WIFI group
            Mailer::send('emails.joinGroups', ['userName' => $samaacountname, 'name' => $name . ' ' . $lastName,
                'manager' => $req->request->get('manager')], function (Message $m) use ($samaacountname)
            {
                $m->to(\Config::get('app.si_infra'), null)->subject('new user settings - ' . $samaacountname);

                // copy NA IT
                $cc[\Config::get('app.eMailITManager')] = \Config::get('app.eMailITManager');
                $cc[\Config::get('app.eMailIT')] = \Config::get('app.eMailIT');

                $m->cc($cc);

            });
        }


        //add reminder for a week before new hre starts
        $dueDate = date('m/d/Y', strtotime('-1 week', strtotime($req->request->get('startDate'))));
        Schedule::addSchedule($dueDate, $samaacountname, $name . ' ' . $lastName, 'newHire_reminder', $req->request->get('startDate'), null, null);

        if (env('APP_STATUS') != 'offline')
        {
            //create the username in the AD
            $ad = ActiveDirectory::get_connection();
            $ad->createUserAD($req);
        }

        return view('thankYou', ['name' => $name, 'lastName' => $lastName,
            'newHireReport' => $newHireReport, 'reportType' => 'newhire',
            'newHireRouteURL' => \Config::get('app.newHireURL'), 'sendMail' => $ccRecipients,
            'payrollReport' => $payrollReport, 'payrollRouteURL' => \Config::get('app.payrollURL')]);
    }

    public function checkEmail(Request $req)
    {
        $ad = ActiveDirectory::get_connection();
        $result = $ad->getEmail($req->request->get('email'));

        if (count($result) > 1)
        {
            return 'true';
        }
        else
        {
            return 'false';
        }
    }


}
