<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return \App\Http\Controllers\Org_ChangeController
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


        Schedule::checkDueDate();

        //        $myFile = \Config::get('app.schedule_batch');
        //var_dump($myFile); die();

        ///$result = file_get_contents($myFile);
        //echo $result;
        //if(!$result) echo 'action failed'; else echo $result;
        //print_r(error_get_last());

        $today = date('m/d/Y');
        //Schedule::addSchedule($today, 'gilra', false, []);
        //echo Schedule::checkDueDate();
        /*
                $dueDate = '6-23-2015';
                $schedule[$dueDate][] = ['samaccountname' => 'gilra', 'deactivate' => true,
                    'groups' => array('group1', 'group2', 'group3')];


                $dueDate = '6-40-2015';
                $schedule[$dueDate][] = ['samaccountname' => 'forstro', 'deactivate' => false,
                    'groups' => array('group1', 'group3')];


                $toSave = json_encode($schedule);

                $schedule1 = json_decode($toSave, true);


                //$today = date('Y-m-d');
                $today = '6-40-2015';
                if (isset($schedule1[$today]))
                {
                    foreach ($schedule1[$today] as $todo)
                    {
                        echo $todo['samaccountname'] . '<br>';
                    }

                }

                unset($schedule1[$today]);
                var_dump($schedule1);

        //        $batchCmds['cmd'] = ''
        */
        die;

        return view('change_org', ['user' => $user]);

    }


    public function lookup(Request $req)
    {
        $uName = $req->request->get('uname');
        $ldap = ActiveDirectory::ldap_MyConnect();
        $result = ActiveDirectory::query("samaccountname={$uName}");

        $fromAD["givenname"] = $result[0]['givenname'][0];
        $fromAD["sn"] = $result[0]['sn'][0];
        $fromAD["title"] = $result[0]['title'][0];
        $fromAD["department"] = $result[0]['department'][0];
        $fromAD["company"] = $result[0]['company'][0];
        $manager = $result[0]['manager'][0];
        $manager = substr($manager, 3, strpos($manager, ',') - 3);
        $fromAD["manager"] = $manager;

        // get the group info
        if (isset($result[0]["memberof"]["count"]) > 0)
        {

            //create arry with user's groups
            for ($i = 0; $i < $result[0]["memberof"]["count"]; $i++)
            {
                $fromAD["groups"][] = substr($result[0]["memberof"][$i], 3, strpos($result[0]["memberof"][$i], ',') - 3);

            }
        }

        $response = new Response(json_encode($fromAD), 200, ['Content-Type' => 'application/json']);

        return $response;

    }


}