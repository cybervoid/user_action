<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Mailer;
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

        $name = trim($req->request->get('name'));
        $lastName = trim($req->request->get('lastName'));


        // generate reports
        $separationReport = \Config::get('app.separationReportsPrefix') . $name . ' ' . $lastName . '.pdf';
        $separationReport = Reports::escapeReportName($separationReport);
        Reports::generateReport($separationReport, \Config::get('app.separationReportsPath'), $req->request->get('reportType'), $req);


        //send the email
        $to = \Config::get('app.servicedesk'); //$to = 'rafael.gil@illy.com';
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
        $ccRecipients = array_unique($ccRecipients);


        // execute proper actions for a separation or schedule one9
        $today = date('m/d/Y');
        $userName = $req->request->get('sAMAccountName');
        $disableUser = $req->request->get('disableUser');

        if ((strtotime($today) >= strtotime($req->request->get('termDate'))))
        {
            //remove user from groups

            $ad = ActiveDirectory::get_connection();
            $ad->removeFromGroups($req->request->get('iTDeptEmail'), $req->request->get('sAMAccountName'));

            //check if the user wants to disable AD user
            if (isset($disableUser))
            {
                $ad->disableUser($userName);
                $ad->removeUserInfo($userName);
            }
        }
        else
        {
            Schedule::addSchedule($req->request->get('termDate'), $userName, $name . ' ' . $lastName, 'separation', isset($disableUser), \Config::get('app.separationReportsPath') . $separationReport, $req->request->get('iTDeptEmail'));
        }

        // add new entry to the schedule system with due date 6 month after effective date for AD deletion
        $dueDate = date('m/d/Y', strtotime('+6 month', strtotime($req->request->get('termDate'))));
        Schedule::addSchedule($dueDate, $userName, $name . ' ' . $lastName, 'separation_reminder', $req->request->get('termDate'), \Config::get('app.separationReportsPath') . $separationReport, $req->request->get('generalComments'));


        return view('thankYou', ['name' => $name, 'lastName' => $lastName,
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

        /*
                if (env('APP_STATUS') == 'offline')
                {
                    $entry = '{"count":1,"0":{"sn":{"count":1,"0":"Gil"},"0":"sn","title":{"count":1,"0":"IT Infrastructure Engineer & Support"},"1":"title","givenname":{"count":1,"0":"Rafael"},"2":"givenname","memberof":{"count":15,"0":"CN=SlideShow_SecurityGrp_NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","1":"CN=HR-Tool,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","2":"CN=Wordpress-editor,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","3":"CN=si_infra_all,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM","4":"CN=RoomUsersUSA,OU=Rooms,OU=New York City,OU=North America,DC=ILLY-DOMAIN,DC=COM","5":"CN=VNC Admin,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM","6":"CN=PC Admins,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM","7":"CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","8":"CN=Report ServiceDesk IC Nord America,CN=Users,DC=ILLY-DOMAIN,DC=COM","9":"CN=Finance NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","10":"CN=VPN illy,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM","11":"CN=Marketing NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","12":"CN=Information Technology NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","13":"CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","14":"CN=Wifi Employees,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM"},"3":"memberof","department":{"count":1,"0":"IT"},"4":"department","company":{"count":1,"0":"illy caff\u00e8 North America, Inc."},"5":"company","samaccountname":{"count":1,"0":"gilra"},"6":"samaccountname","mail":{"count":1,"0":"Rafael.Gil@illy.com"},"7":"mail","manager":{"count":1,"0":"CN=Roy Forster,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM"},"8":"manager","count":9,"dn":"CN=Rafael Gil,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM"}}';
                }
                else
                {
                    $ad = ActiveDirectory::get_connection();
                    $entry = $ad->getEmail($email);
                }
        */
        //$entry = ActiveDirectory::getEmail($email);

        $ad = ActiveDirectory::get_connection();
        $entry = $ad->getEmail($email);

        print_r($entry);
        die;


        $fromAD["givenname"] = $entry[0]["givenname"][0];
        $fromAD["sn"] = $entry[0]["sn"][0];
        if (isset($entry[0]["department"][0]))
        {
            $fromAD["department"] = $entry[0]["department"][0];
        }
        if (isset($entry[0]["title"][0]))
        {
            $fromAD["title"] = $entry[0]["title"][0];
        }
        if (isset($entry[0]["company"][0]))
        {
            $fromAD["company"] = $entry[0]["company"][0];
        }

        $fromAD["sAMAccountName"] = $entry[0]["samaccountname"][0];


        // get manager name and email
        if (isset($entry[0]['manager'][0]))
        {

            $managerInfo = $ad->getManager($entry[0]['manager'][0]);
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
