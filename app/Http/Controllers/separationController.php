<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        // generate reports
        $separationReport = \Config::get('app.separationReportsPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName') . '.pdf';
        $separationReport = Reports::escapeReportName($separationReport);
        Reports::generateReport($separationReport, \Config::get('app.separationReportsPath'), $req->request->get('reportType'), $req);


        //send the email
        $to = \Config::get('app.servicedesk'); //$to = 'rafael.gil@illy.com';
        $ccRecipients = MyMail::emailRecipients($req);
        $subject = \Config::get('app.subjectPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName');

        if (env('APP_ENV') == 'live')
        {
            MyMail::send_mail($to, $ccRecipients, $subject, \Config::get('app.emailBody'), \Config::get('app.separationReportsPath') . $separationReport);
        }
        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique($ccRecipients);

        $today = date('m/d/Y');
        $userName = $req->request->get('sAMAccountName');
        $disableUser = $req->request->get('disableUser');

        if ((strtotime($today) >= strtotime($req->request->get('termDate'))))
        {
            //remove user from groups
            ActiveDirectory::removeFromGroups($req->request->get('iTDeptEmail'), $req->request->get('sAMAccountName'));

            //check if the user wants to disable AD user
            if (isset($disableUser))
            {
                ActiveDirectory::disableUser($userName);
                ActiveDirectory::removeUserInfo($userName);
            }
        }
        else
        {
            Schedule::addSchedule($req->request->get('termDate'), $userName, $req->request->get('name') . ' ' . $req->request->get('lastName'), 'separation', isset($disableUser), $separationReport, $req->request->get('iTDeptEmail'));
        }


        return view('thankYou', ['name' => $req->request->get('name'), 'lastName' => $req->request->get('lastName'),
            'separationReport' => $separationReport, 'reportType' => 'separation',
            'separationRouteURL' => \Config::get('app.separationURL'), 'sendMail' => $ccRecipients]);

    }


    public function separation_search(Request $req)
    {

        $email = $req->request->get('email');
        if (!preg_match("/@illy.com/", $email))
        {
            $email = $email . '@illy.com';
        }
        $email = preg_replace('/\s+/', '', $email);
        //$array['email'] = $email;

        $entry = ActiveDirectory::getEmail($email);


        $fromAD["givenname"] = $entry[0]["givenname"][0];
        $fromAD["sn"] = $entry[0]["sn"][0];
        if (isset($entry[0]["department"][0]))
        {
            $fromAD["department"] = $entry[0]["department"][0];
        }
        if (isset($entry[0]["title"][0]))
        $fromAD["title"] = $entry[0]["title"][0];
        if (isset($entry[0]["company"][0]))
        $fromAD["company"] = $entry[0]["company"][0];

        $fromAD["sAMAccountName"] = $entry[0]["samaccountname"][0];


        // get manager name and email
        if (isset($entry[0]['manager'][0]))
        {
            $ldap = ActiveDirectory::ldap_MyConnect();
            $consult = ldap_search($ldap, $entry[0]['manager'][0], "(objectclass=*)", ['mail', 'sn', 'givenname']);
            $managerInfo = ldap_get_entries($ldap, $consult);
            $fromAD["manager"] = $managerInfo[0]['givenname'][0] . ' ' . $managerInfo[0]['sn'][0];
            $fromAD["managerEmail"] = $managerInfo[0]['mail'][0];
        }


        // get the group info
        if (isset($entry[0]["memberof"]["count"]) > 0)
        {

            //create arry with user's groups
            for ($i = 0; $i < $entry[0]["memberof"]["count"]; $i++)
            {
                $fromAD["groups"][] = substr($entry[0]["memberof"][$i], 3, strpos($entry[0]["memberof"][$i], ',') - 3);

            }
        }

        $response = new Response(json_encode($fromAD), 200, ['Content-Type' => 'application/json']);

        return $response;


    }
}
