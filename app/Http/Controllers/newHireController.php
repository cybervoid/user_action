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
        /*REVISAR COMO CAPTURAR LOS ERRORES SI EL EMAIL NO SE PUEDE ENVIAR POR ALGUN MOTIVO*/
        $newHireReport = 'Action User Notification-' . $req->request->get('name') . ' ' . $req->request->get('lastName') . '.pdf';
        $this->generateReport($newHireReport, $req);

        //* send the form by email *//
        $ccRecipients = '';

        $iTDeptEmail = $req->request->get('iTDeptEmail');
        if (isset($iTDeptEmail))
        {
            $ccRecipients[\Config::get('app.eMailIT')] = \Config::get('app.eMailIT');
        }

        $oracle = $req->request->get('oracle');
        if (isset($oracle))
        {
            $ccRecipients[\Config::get('app.eMailOracle')] = \Config::get('app.eMailOracle');
        }

        $oManager = $req->request->get('oManager');
        if (isset($oManager))
        {
            $ccRecipients[\Config::get('app.eMailManagement')] = \Config::get('app.eMailManagement');
            $ccRecipients[\Config::get('app.eMailManagement1')] = \Config::get('app.eMailManagement1');
        }

        $creditCard = $req->request->get('creditCard');
        if (isset($creditCard))
        {
            $ccRecipients[\Config::get('app.eMailFinanceCreditCard')] = \Config::get('app.eMailFinanceCreditCard');
        }

        $newDriver = $req->request->get('newDriver');
        if (isset($newDriver))
        {
            $ccRecipients[\Config::get('app.eMailFinanceDrivers')] = \Config::get('app.eMailFinanceDrivers');
        }


        // Per Maren's request include Stacey when we hire Sales Person
        if ($req->request->get('department') == 'Sales')
        {
            $ccRecipients['Stacey.Berger@illy.com'] = 'Stacey.Berger@illy.com';
        }

        // Per Maren's request include lisa Gutman in all the requests
        $ccRecipients['Lissa.Guttman@illy.com'] = 'Lissa.Guttman@illy.com';

        //Add the manager's email in the recipients list
        if ($req->request->get('managerEmail') != '')
        {
            $ccRecipients[$req->request->get('managerEmail')] = $req->request->get('managerEmail');
        }

        $sendMailResult = $this->sendMail($req->request->get('name') . ' ' . $req->request->get('lastName'), $ccRecipients, storage_path() . '\\reports\\New_Hires\\' . $newHireReport);


        //create the username in the AD
        $this->createUserAD($req);

        return view('newHireThankYou', ['name' => $req->request->get('name'),
            'lastName' => $req->request->get('lastName'), 'newHireReport' => $newHireReport,
            'sendMail' => $sendMailResult]);
    }

    /**
     * Generate the report in the temp folder
     *
     * @param $reportName
     * @param Request $req
     */

    private function generateReport($reportName, Request $req)
    {
        $myFile = sys_get_temp_dir() . "\\export.html";
        $toPDF = fopen($myFile, "w");

        //get the domain so I can load the image on the PDF
        $parse = parse_url($req->url());

        if ($req->request->get('employee') == "")
        {
            $req->request->set('employee', 'TBD');
        }


        $myView = view('newHireToPDF', ['req' => $req->request->all(),
            'server' => $parse['scheme'] . '://' . $parse['host'] . '/',]);


        fwrite($toPDF, $myView);
        fclose($toPDF);
        //convert to pdf
        $error = array();

        exec('"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe" ' . $myFile . ' ' . '"' . storage_path() . '\\reports\\New_Hires\\' . $reportName . '"', $error);

    }


    /**
     * Transfer the report so the user can download it
     *
     * @param Request $req
     *
     * @return Response
     */
    public function getReport(Request $req)
    {
        $name = $req->route('name');
        $filePath = \Config::get('app.newHireReportsPath') . $name;
        $content = file_get_contents($filePath);

        /*
        return new Response($content, Response::HTTP_OK, ["content-type" => "application/pdf",
            "content-length" => filesize($filePath), "content-disposition" => "inline; filename=\"$name\""]);
        */

        return new Response($content, Response::HTTP_OK, ["content-type" => "application/pdf",
            "content-length" => filesize($filePath), "content-disposition" => "attachment; filename=\"$name\""]);

    }


    /**
     * Send the email and return the list of recipients
     *
     * @param $name
     * @param $cc
     * @param $attachment
     *
     * @internal param $attachement
     *
     * @return array
     */
    public function sendMail($name, $cc, $attachment)
    {

        $recipient = \Config::get('app.recipient');
        $ccRecipients[] = \Config::get('app.eMailHRAdd');

        /*
        $recipient = 'rafael.gil@illy.com';
        $ccRecipients['rafaelgil83@gmail.com'] = 'rafaelgil83@gmail.com';
*/
        // get other recipients

        if ($cc != '')
        {
            foreach ($cc as $emailAdd)
            {
                $ccRecipients[$emailAdd] = $emailAdd;
            }
        }


        $ccRecipients[] = $recipient;
        $ccRecipients = array_unique($ccRecipients);

        return $ccRecipients;

        /*
                if (!Mail::send_mail($recipient, $ccRecipients, 'USER NOTIFICATION - ' . $name, 'Hi Team, please see attached.', $attachment))
                {
                    //$error = 'An error ocurred while trying to email the reports, please contact IT.';
                    //echo $error;
                    return false;
                }
                else
                {
                    $ccRecipients[] = $recipient;
                    return $ccRecipients;
                }
        */
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

}
