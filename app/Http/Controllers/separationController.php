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
        $ccRecipients = Mail::emailRecipients($req);
        $subject = \Config::get('app.subjectPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName');
//        Mail::send_mail($to, $ccRecipients, $subject, \Config::get('app.emailBody'), \Config::get('app.separationReportsPath') . $separationReport);
        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique($ccRecipients);

        //check if the user wants to disable AD user
        $disableUser = $req->request->get('disableUser');
        if (isset($disableUser))
        {
            $userName = $req->request->get('sAMAccountName');
            //          $this->disableUser($userName);

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
        $fromAD["department"] = $entry[0]["department"][0];
        $fromAD["title"] = $entry[0]["title"][0];
        $fromAD["company"] = $entry[0]["company"][0];

        $fromAD["sAMAccountName"] = $entry[0]["samaccountname"][0];


        // get manager name and email
        $ldap = ActiveDirectory::ldap_MyConnect();
        $consult = ldap_search($ldap, $entry[0]['manager'][0], "(objectclass=*)", ['mail', 'sn', 'givenname']);
        $managerInfo = ldap_get_entries($ldap, $consult);
        $fromAD["manager"] = $managerInfo[0]['givenname'][0] . ' ' . $managerInfo[0]['sn'][0];

        $fromAD["managerEmail"] = $managerInfo[0]['mail'][0];


        // get the group info
        if (isset($entry[0]["memberof"]["count"]) > 0)
        {

            //create arry with user's groups
            for ($i = 0; $i < $entry[0]["memberof"]["count"]; $i++)
            {
                $fromAD["groups"][] = substr($entry[0]["memberof"][$i], 3, strpos($entry[0]["memberof"][$i], ',') - 3);
            }
        }

        //print_r($fromAD["groups"]);


        //$fromAD["memberOf"] = $managerInfo[0]['memberof'][0];
        //echo 'contador: ' . $managerInfo[0]['memberof']['count'];

        // get member info for this user
        //$consult = ldap_search($ldap, $entry[0]['manager'][0], "(objectclass=*)" , ['mail','sn','givenname']);
        $managerInfo = ldap_get_entries($ldap, $consult);


        $response = new Response(json_encode($fromAD), 200, ['Content-Type' => 'application/json']);

        return $response;


    }


    private function disableUser($userName)
    {
        $attributes = array('dn', 'useraccountcontrol');
        $ldap = ActiveDirectory::ldap_MyConnect();
        $myDN = "OU=North America,DC=ILLY-DOMAIN,DC=COM";
        $txtSearch = "samaccountname={$userName}";
        $result = ldap_search($ldap, $myDN, $txtSearch, $attributes);
        $entry = ldap_get_entries($ldap, $result);
        $dn = $entry[0]["dn"];
        $ac = $entry[0]["useraccountcontrol"][0];
        $disable = ($ac | 2); // set all bits plus bit 1 (=dec2)
        $userdata = array();
        $userdata["useraccountcontrol"][0] = $disable;
        ldap_modify($ldap, $dn, $userdata); //change state

    }
}