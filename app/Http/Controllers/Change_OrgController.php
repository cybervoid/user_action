<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use App\Services\ActiveDirectory;
use App\Services\Lookup;


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
        return Lookup::lookupUser($req);
    }

    public function verify(Request $req)
    {

        $ad = ActiveDirectory::get_connection();
        $result = $ad->getEmail($req->request->get('email'));


        $changes = Array();
        if (env('APP_STATUS') != 'offline')
        {

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
                $changes['email'] = $req->request->get('newEmail');
            }

            if (strtolower($req->request->get('department')) != strtolower($result[0]['department'][0]))
            {
                $changes['department'] = $req->request->get('department');
            }

        }
        else
        {  // OFFLINE MODE, DELETE THIS LATER

            if (strtolower($req->request->get('name')) != strtolower($result['givenname']))
            {
                $changes['givenname'] = $req->request->get('name');
            }

            if (strtolower($req->request->get('lastName')) != strtolower($result['sn']))
            {
                $changes['sn'] = $req->request->get('lastName');
            }

            if (strtolower($req->request->get('email')) != strtolower($req->request->get('newEmail')))
            {
                $changes['mail'] = $req->request->get('newEmail');
            }

            if (strtolower($req->request->get('department')) != strtolower($result['department']))
            {
                $changes['department'] = $req->request->get('department');
            }

            if (strtolower($req->request->get('company')) != strtolower($result['company']))
            {
                $changes['company'] = $req->request->get('company');
            }

            if (strtolower($req->request->get('title')) != strtolower($result['title']))
            {
                $changes['title'] = $req->request->get('title');
            }

            if (strtolower($req->request->get('manager')) != strtolower($result['manager']))
            {
                $changes['manager'] = $req->request->get('manager');
            }
        }


        return view('change_org_verify', ['changes' => $changes, 'fromAD' => $result, 'req' => $req->request->all()]);
    }

    public function save(Request $req)
    {
        $params = json_decode(base64_decode($req->request->get('params')), true);
        echo 'saving info: ' . $params['name'];

    }


}