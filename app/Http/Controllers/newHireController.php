<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
        Reports::generateReport($newHireReport, \Config::get('app.newHireReportsPath'), $req->request->get('reportType'), $req);


        //generate payroll Report
        $payrollReport = \Config::get('app.payrollReportsPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName') . '.pdf';
        $payrollReport = Reports::escapeReportName($payrollReport);
        Reports::generateReport($payrollReport, \Config::get('app.payrollReportsPath'), 'payroll', $req);

        //send the email

        if (env('APP_ENV') == 'testlive')
        {
            $to = 'rafael.gil@illy.com';
            $ccRecipients = [];
        }
        else
        {
            $to = \Config::get('app.servicedesk');
            $ccRecipients = MyMail::emailRecipients($req);
        }



        $subject = \Config::get('app.subjectPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName');
        if (env('APP_ENV') == 'live')
        {
            MyMail::send_mail($to, $ccRecipients, $subject, \Config::get('app.emailBody'), \Config::get('app.newHireReportsPath') . $newHireReport);
        }


        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique($ccRecipients);

        //create the username in the AD
        if (env('APP_ENV') == 'live')
        {
            $ad = ActiveDirectory::get_connection();
            $ad->createUserAD($req);
        }


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
