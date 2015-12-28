<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\Services\Reports;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Lookup;
use App\Services\Mailer;
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


        //return new Response($result, 200, ['content-type' => 'application/json']);

        return view('change_org', ['user' => $user]);


    }


    public function lookup(Request $req)
    {

        $result_array['fromAD'] = Lookup::lookupUser($req);
        $result_array['departments'] = \Config::get('app.departments');
        $result_array['companies'] = \Config::get('app.companies');
        $result_array['hireStatus'] = \Config::get('app.hireStatus');

        return new Response(json_encode($result_array), 200, ['Content-Type' => 'application/json']);
        /*
        $response = new Response(json_encode($result_array), 200, ['Content-Type' => 'application/json']);

        return $response;
        */
    }

    public function verify(Request $req)
    {

        $ad = ActiveDirectory::get_connection();
        $result = $ad->getEmail($req->request->get('email'));

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
            $changes['company'] = $req->request->get('company');
        }


        // compare managers, get manager's dn based on the email

        $resultManager = $ad->getEmail($req->request->get('managerEmail'));
        $manager = [];
        if (strtolower($resultManager[0]['dn']) != strtolower($result[0]['manager'][0]))
        {
            $changes['manager'] = $req->request->get('managerEmail');
            $manager['name'] = $resultManager[0]['givenname'][0] . ' ' . $resultManager[0]['sn'][0];

            $oldManager = $ad->getManager($result[0]['manager'][0]);
            $manager['oldManager'] = $oldManager[0]['givenname'][0] . ' ' . $oldManager[0]['sn'][0];

        }

        return view('change_org_verify', ['changes' => $changes, 'fromAD' => $result, 'req' => $req->request->all(),
            'menu_Home' => '', 'menu_Org_Change' => '', 'manager' => $manager]);
    }


    /*
     * Request has all the changes for this user
     */


    public function save(Request $req)
    {

        // rafag me quede en aplicar los email distribution list
        $REPORT_TYPE = 'change_org';

        $params = json_decode(base64_decode($req->request->get('params')), true);

        $ad = ActiveDirectory::get_connection();
        $result = $ad->getEmail($req["email"]);

        //if one of the changes is manager get extra info
        if(isset($params['manager'])){
            $getManager= $ad->getEmail($params['manager']);
            $result['newManager']= $getManager[0]['dn'];
            $oldManager= $ad->getManager($result[0]['manager'][0]);
            $view['newManagerName']=  $getManager[0]['givenname'][0] . ' ' . $getManager[0]['sn'][0];// use this var later on the view
            $view['oldManagerName']=  $oldManager[0]['givenname'][0] . ' ' . $oldManager[0]['sn'][0];// use this var later on the view
        }


        // make the change permanent in AD
        if(!empty($params)) $ad->change_org_Save($result[0]['dn'], $params, $result);


        if (!isset($result[0]['givenname'][0]))
        {
            echo 'Something went wrong, please contact your administrator. <a href="/">Go Home</a>';
            die;
        }

        //some var declarations
        $name = $result[0]['givenname'][0];
        $lastName = $result[0]['sn'][0];
        if(isset($result['newManager'])) $manager= $result['newManager']; else
            $manager = $result[0]['manager'][0];

        //generate report
        $change_org_Report = \Config::get('app.org_change_ReportsPrefix') . $name . ' ' . $lastName . '.pdf';
        $change_org_Report = Reports::escapeReportName($change_org_Report);

        // set variables needed in the view
        $view['changes'] = $params;
        $view['fromAD'] = $result;
        $view['url'] = $req->url();
        if($req->request->get('itComments')!= ''){
            $view['itComments'] = $req->request->get('itComments');
        } else $view['itComments']= '';


        Reports::generateReport($change_org_Report, \Config::get('app.change_org_ReportsPath'), $REPORT_TYPE, $view);

        //send the email
        $to = \Config::get('app.servicedesk');
        $manager = $ad->getManager($manager);
        $req->request->add(['managerEmail' => $manager[0]['mail'][0]]);

        $ccRecipients = MyMail::emailRecipients($req);
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
        $ccRecipients = array_unique(array_map("StrToLower",$ccRecipients));

        return view('thankYou', ['name' => $name, 'lastName' => $lastName, 'reportType' => $REPORT_TYPE,

            'change_org_URL' => \Config::get('app.change_org_URL'), 'sendMail' => $ccRecipients, 'menu_Home' => '',
            'menu_Org_Change' => '', 'change_org_Report' => $change_org_Report,]);


    }


}