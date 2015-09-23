<?php namespace App\Http\Controllers;

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


}