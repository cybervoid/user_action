<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Lookup;
use App\Services\Mailer;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;


class Change_OrgController extends Controller
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
        return view('change_org', ['user' => $user]);
    }


    public function lookup(Request $req)
    {

        $result_array['fromAD'] = Lookup::lookupUser($req);
        $result_array['departments'] = \Config::get('app.departments');
        $result_array['companies'] = \Config::get('app.companies');
        $result_array['hireStatus'] = \Config::get('app.hireStatus');

        return new Response(json_encode($result_array), 200, ['Content-Type' => 'application/json']);

    }

    public function verify(Request $req)
    {

        $ad = ActiveDirectory::get_connection();
        $result = $ad->getEmail($req->request->get('email'));
        $currentManager = '';
        if (isset($result[0]['manager'][0]))
        {
            $currentManager = $result[0]['manager'][0];
        }
        else
        {
            $result[0]['manager'][0] = '';
        }


        $changes = Array();

        // Identify changes comparing sent values with AD
        if (strtolower($req->request->get('name')) != strtolower($result[0]['givenname'][0]))
        {
            $changes['givenname'] = $req->request->get('name');
        }

        if (strtolower($req->request->get('lastName')) != strtolower($result[0]['sn'][0]))
        {
            $changes['sn'] = $req->request->get('lastName');
        }

        if (strtolower($req->request->get('email')) != strtolower($req->request->get('newEmail')))
        {
            $changes['mail'] = $req->request->get('newEmail');
        }

        if (strtolower($req->request->get('department')) != strtolower($result[0]['department'][0]))
        {
            $changes['department'] = $req->request->get('department');
        }

        if (strtolower($req->request->get('title')) != strtolower($result[0]['title'][0]))
        {
            $changes['title'] = $req->request->get('title');
        }

        if (strtolower($req->request->get('company')) != strtolower($result[0]['company'][0]))
        {
            //check if the user comes from another company or didn't one assigned, if not
            // set one as default
            if (in_array($result[0]['company'][0], \Config::get('app.companies')))
            {
                $changes['company'] = $req->request->get('company');
            }
        }


        // compare managers, get manager's dn based on the email
        if ($req->request->get('managerEmail') != '')
        {
            $resultManager = $ad->getEmail($req->request->get('managerEmail'));

            $manager = [];
            if (strtolower($resultManager[0]['dn']) != strtolower($currentManager))
            {
                $changes['manager'] = $req->request->get('managerEmail');
                $manager['name'] = $resultManager[0]['givenname'][0] . ' ' . $resultManager[0]['sn'][0];

                if ($currentManager != '')
                {
                    $oldManager = $ad->getManager($currentManager);
                    $manager['oldManager'] = $oldManager[0]['givenname'][0] . ' ' . $oldManager[0]['sn'][0];
                }
                else
                {
                    $manager['oldManager'] = 'none';
                }
            }
        } else $manager='';

        return view('change_org_verify', ['changes' => $changes, 'fromAD' => $result, 'req' => $req->request->all(),
            'menu_Home' => '', 'menu_Org_Change' => '', 'manager' => $manager]);
    }


    /*
     * Request has all the changes for this user
     */
    public function save(Request $req)
    {

        $REPORT_TYPE = 'change_org';

        $params = json_decode(base64_decode($req->request->get('params')), true);
        $main_req = json_decode(base64_decode($req->request->get('main_req')), true);

        $ad = ActiveDirectory::get_connection();
        $result = $ad->getEmail($req["email"]);

        $name = $result[0]['givenname'][0];
        $lastName = $result[0]['sn'][0];
        $change_org_Report = \Config::get('app.org_change_ReportsPrefix') . $name . ' ' . $lastName . date('_m-d-Y') . '.pdf';
        $change_org_Report = Reports::escapeReportName($change_org_Report);

        //if one of the changes is manager get extra info
        if (isset($params['manager']))
        {
            $managerEmail = $params['manager'];
            $getManager = $ad->getEmail($params['manager']);
            $result['newManager'] = $getManager[0]['dn'];
            if (isset($result[0]['manager'][0]))
            {
                $oldManager = $ad->getManager($result[0]['manager'][0]);
                $view['oldManagerName'] = $oldManager[0]['givenname'][0] . ' ' . $oldManager[0]['sn'][0];// use this var later on the view
            }
            else
            {
                $view['oldManagerName'] = 'none';
                $result[0]['manager'][0] = '';
            }
            $view['newManagerName'] = $getManager[0]['givenname'][0] . ' ' . $getManager[0]['sn'][0];// use this var later on the view
        } else{
            if(isset($result[0]['manager'][0])){
                $oldManager= $ad->getManager($result[0]['manager'][0]);
                $managerEmail= $oldManager[0]['mail'][0];
            } else $managerEmail = '';
        }

        // make the change permanent in AD
        if (!empty($params) && $main_req['effectiveDate'] != '')
        {
            //CHECK IF SCHEDULE FOR TODAY OR A FUTURE DATE
            $today = date('m/d/Y');
            if ((strtotime($today) < strtotime($main_req['effectiveDate'])))
            {
                $schedule['samaccountname'] = $result[0]['samaccountname'][0];
                $schedule['name'] = $main_req['name'] . ' ' . $main_req['lastName'];
                $schedule['action'] = 'Org_Change';
                $schedule['request_date'] = $today;
                $schedule['attachment'] = \Config::get('app.change_org_ReportsPath') . $change_org_Report;

                $schedule['changes'] = $params;
                Schedule::createSchedule($main_req['effectiveDate'], $schedule);

            }
            else
            {
                $ad->change_org_Save($result[0]['dn'], $params, $result);
            }
        }


        if (!isset($result[0]['givenname'][0]))
        {
            echo 'Something went wrong, please contact your administrator. <a href="/">Go Home</a>';
            die;
        }


        //generate report
        // set variables needed in the view
        $view['changes'] = $params;
        $view['fromAD'] = $result;
        $view['main_req'] = $main_req;
        $view['url'] = $req->url();

        if ($req->request->get('itComments') != '')
        {
            $view['itComments'] = $req->request->get('itComments');
        }
        else
        {
            $view['itComments'] = '';
        }

        Reports::generateReport($change_org_Report, \Config::get('app.change_org_ReportsPath'), $REPORT_TYPE, $view);

        //SEND THE MAIL
        $to = \Config::get('app.servicedesk');

        $mailNotifyDepartments= array('management');
        if ($view['main_req']['department'] == 'Sales')
        {
            $mailNotifyDepartments[]= 'sales';
        }
        $ccRecipients= MyMail::getRecipients( 'change_org',$mailNotifyDepartments, $managerEmail);

        $subject = \Config::get('app.subjectPrefix') . $name . ' ' . $lastName;
        $attachment = \Config::get('app.change_org_ReportsPath') . $change_org_Report;
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

        return view('thankYou', ['name' => $name, 'lastName' => $lastName, 'reportType' => $REPORT_TYPE,

            'change_org_URL' => \Config::get('app.change_org_URL'), 'sendMail' => $ccRecipients, 'menu_Home' => '',
            'menu_Org_Change' => '', 'change_org_Report' => $change_org_Report,]);


    }

    public static function update_signature($name, $email, $changes, $currentInfo)
    {

        $to = $email;
        $ccRecipients[\Config::get('app.eMailIT')] = \Config::get('app.eMailIT');
        $ccRecipients[\Config::get('app.eMailHRAdd')] = \Config::get('app.eMailHRAdd');
        $ccRecipients[\Config::get('app.eMailITManager')] = \Config::get('app.eMailITManager');
        $subject = 'changes for user ' . $name;

        Mailer::send('emails.signature_update', ['name' => $name, 'changes' => $changes,
            'currentInfo' => $currentInfo], function (Message $m) use ($to, $ccRecipients, $subject)
        {
            $m->to($to, null)->subject($subject)->cc($ccRecipients, null);
        });

    }


}