<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
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
     * @return \App\Http\Controllers\LoginController
     */

    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('login');
    }

    public function check_password(Request $req)
    {

        $user = User::check_password($req);


        if ($user)
        {
            return redirect('/');
        }
        else
        {
            return redirect('login')->with('message', 'Login Failed');
        }

    }
}
