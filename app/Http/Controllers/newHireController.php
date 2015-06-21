<?php namespace App\Http\Controllers;

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
        $to = \Config::get('app.servicedesk'); //$to = 'rafael.gil@illy.com';
        $ccRecipients = Mail::emailRecipients($req);
        $subject = \Config::get('app.subjectPrefix') . $req->request->get('name') . ' ' . $req->request->get('lastName');
        //Mail::send_mail($to, $ccRecipients, $subject, \Config::get('app.emailBody'), \Config::get('app.newHireReportsPath') . $newHireReport);
        $ccRecipients[$to] = $to;
        $ccRecipients = array_unique($ccRecipients);

        //create the username in the AD
        //$this->createUserAD($req);


        return view('thankYou', ['name' => $req->request->get('name'), 'lastName' => $req->request->get('lastName'),
            'newHireReport' => $newHireReport, 'reportType' => 'newhire',
            'newHireRouteURL' => \Config::get('app.newHireURL'), 'sendMail' => $ccRecipients,
            'payrollReport' => $payrollReport, 'payrollRouteURL' => \Config::get('app.payrollURL')]);
    }


    private function createUserAD(Request $req)
    {


//        $dn_user = ("CN=test LDAP,OU=Users,OU=Canada,OU=North America,DC=ILLY-DOMAIN,DC=COM");

        $name = trim($req->request->get('name'));
        $lastName = trim($req->request->get('lastName'));

        $ldaprecord['cn'] = ucfirst(strtolower($name)) . " " . ucfirst(strtolower($lastName));
        $ldaprecord['givenName'] = ucfirst(strtolower($name));
        $ldaprecord['sn'] = ucfirst(strtolower($lastName));
        $ldaprecord['title'] = ucwords(strtolower($req->request->get('title')));
        $ldaprecord['Description'] = ucwords(strtolower($req->request->get('title')));
        $ldaprecord['sAMAccountName'] = strtolower(substr($lastName, 0, 5) . substr($name, 0, 2));
        $ldaprecord['UserPrincipalName'] = $ldaprecord['sAMAccountName'] . "@ILLY-DOMAIN.COM";
        $ldaprecord['displayName'] = ucfirst(strtolower($lastName)) . " " . ucfirst(strtolower($name));
        //    $req->request->get('')
        $ldaprecord['department'] = $req->request->get('department');
        $ldaprecord['company'] = $req->request->get('company');


        if ($req->request->get('location') == "New York City")
        {
            $ldaprecord['streetAddress'] = "275 Madison Avenue, 31st Floor";
            $ldaprecord['st'] = "NY";
            $ldaprecord['postalCode'] = "10016";
            $ldaprecord['l'] = "New York";
            $ldaprecord['c'] = "US";
        }
        else
        {
            if ($ldaprecord['company'] == 'Espressamente illy')
            {
                $ldaprecord['streetAddress'] = "800 Westchester Avenue, Suite S438";
            }
            else
            {
                $ldaprecord['streetAddress'] = "800 Westchester Avenue, Suite S440";
            }

            $ldaprecord['st'] = "NY";
            $ldaprecord['postalCode'] = "10573";
            $ldaprecord['l'] = "Rye Brook";
            $ldaprecord['c'] = "US";
        }

        $ldaprecord['displayName'] = ucfirst(strtolower($lastName)) . " " . ucfirst(strtolower($name));

        if ($req->request->get('location_Other') != '')
        {
            $ldaprecord['physicalDeliveryOfficeName'] = $req->request->get('location_Other');
        }
        else
        {
            $ldaprecord['physicalDeliveryOfficeName'] = $req->request->get('location');
        }
        $ldaprecord['telephoneNumber'] = "+1 914 253 4";
        $ldaprecord['UserAccountControl'] = "544";
        $ldaprecord['objectclass'][0] = 'top';
        $ldaprecord['objectclass'][1] = 'person';
        $ldaprecord['objectclass'][2] = 'organizationalPerson';
        $ldaprecord['objectclass'][3] = 'user';
        $ldaprecord['mail'] = strtolower($name . "." . $lastName) . "@illy.com";

        $ldap = ActiveDirectory::ldap_MyConnect();
        //search manager DN by email
        if ($req->request->get('managerEmail') != '')
        {
            $ldap = ActiveDirectory::ldap_MyConnect();
            //$managerEmail= $req->request->get('managerEmail');
            $consult = ldap_search($ldap, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "mail={$req->request->get('managerEmail')}", ['distinguishedName']);
            $managerInfo = ldap_get_entries($ldap, $consult);
            if (isset($managerInfo[0]['distinguishedname'][0]))
            {
                $ldaprecord["manager"] = $managerInfo[0]['distinguishedname'][0];
            }
        }


//create the user in the system
        $dn_user = ("CN=" . $ldaprecord['cn'] . ",OU=Users,OU=" . $req->request->get('location') . ",OU=North America,DC=ILLY-DOMAIN,DC=COM");
        @ldap_add($ldap, $dn_user, $ldaprecord);


        //define and join user to groups
        $illyGroups['illyusaNorth America'] = 'CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyryebrook'] = 'CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyusa NYC Team'] = 'CN=illy NYC Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyManagers'] = 'CN=illyusa Managers Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illySales'] = 'CN=illyusa Sales Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';

        $group_info['member'] = $dn_user;

        $groupsToAdd = $req->request->get('iTDeptEmail');
        if (isset($groupsToAdd))
        {
            foreach ($groupsToAdd as $group)
            {
                @ldap_mod_add($ldap, $illyGroups[$group], $group_info);
            }
        }

    }

    public function checkEmail(Request $req)
    {
        //return $req->request->get('email');
        $result = ActiveDirectory::getEmail($req->request->get('email'));
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
