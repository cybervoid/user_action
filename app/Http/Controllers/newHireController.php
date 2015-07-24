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

        // generate newHire reports
        $newHireReport = \Config::get('app.newHireReportsPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName') . '.pdf';
        $newHireReport = Reports::escapeReportName($newHireReport);
        $result = Reports::generateReport($newHireReport, \Config::get('app.newHireReportsPath'), $req->request->get('reportType'), $req);


        //return $result;

        //generate payroll Report
        $payrollReport = \Config::get('app.payrollReportsPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName') . '.pdf';
        $payrollReport = Reports::escapeReportName($payrollReport);
        Reports::generateReport($payrollReport, \Config::get('app.payrollReportsPath'), 'payroll', $req);

        //send the email
        $to = \Config::get('app.servicedesk');
        $ccRecipients = MyMail::emailRecipients($req);
        $subject = \Config::get('app.subjectPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName');

        $attachment = \Config::get('app.newHireReportsPath') . $newHireReport;
        $attachment = isset($attachment) ? file_exists($attachment) ? $attachment : false : null;

        Mailer::send('emails.forms', [], function (Message $m) use ($to, $ccRecipients, $subject, $attachment)
        {
            $m->to($to, null)->subject($subject);
            $m->cc($ccRecipients);

            if ($attachment)
            {
                $m->attach($attachment);
            }
        });


        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique($ccRecipients);


        $illyGroups['illyusaNorth America'] = 'CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyryebrook'] = 'CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyusa NYC Team'] = 'CN=illy NYC Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyManagers'] = 'CN=illyusa Managers Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illySales'] = 'CN=illyusa Sales Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';

        $groupsToAdd = $req->request->get('iTDeptEmail');
        if (isset($groupsToAdd))
        {
            foreach ($groupsToAdd as $group)
            {
                $groups[] = $illyGroups[$group];
            }
        }


        $samaacountname = strtolower(substr($req->request->get('lastName'), 0, 5) . substr($req->request->get('name'), 0, 2));

        //send request to si_infra to add the user to VPN and WIFI group
        Mailer::send('emails.joinGroups', ['userName' => $samaacountname,
            'name' => $req->request->get('name') . ' ' . $req->request->get('lastName'),
            'manager' => $req->request->get('manager')], function (Message $m) use ($samaacountname)
        {
            $m->to(\Config::get('app.si_infra'), null)->subject('new user settings - ' . $samaacountname);

            // copy NA IT
            $cc[\Config::get('app.eMailITManager')] = \Config::get('app.eMailITManager');
            $cc[\Config::get('app.eMailIT')] = \Config::get('app.eMailIT');

            $m->cc($cc);

        });


        //add reminder for a week before new hre starts
        $dueDate = date('m/d/Y', strtotime('-1 week', strtotime($req->request->get('startDate'))));
        Schedule::addSchedule($dueDate, $samaacountname, $req->request->get('name') . ' ' . $req->request->get('lastName'), 'newHire_reminder', $req->request->get('startDate'), null, null);

        //create the username in the AD
        $ad = ActiveDirectory::get_connection();
        $ad->createUserAD($req);

        return view('thankYou', ['name' => $req->request->get('name'), 'lastName' => $req->request->get('lastName'),
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
