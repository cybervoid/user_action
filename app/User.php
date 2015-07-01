<?php namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class User implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    public $id; //sAMAccountName
    public $givenName;
    public $sn;


    /**
     * @param Request $req
     *
     * @return User|null
     */
    public static function check_password(Request $req)
    {
        //todo check AD password
        // if password not correct return null

        $result = Ldap::ldap_login_validate($req->input('userName'), $req->input('password'));


        if (!$result){ return false; }

        if (isset($result[0]["count"]))
        {
            //$_SESSION['userName'] = $result[0]["cn"][0];
            $user = new User();
            $user->givenName = $result[0]["givenname"][0];
            $user->id = $result[0]["samaccountname"][0];

            /*
            $user->id = 'gilra';

            $user->sn = 'Gil';
            */
            Session::put('user_id', $user->id);
            Session::put('givenName', $user->givenName);

            return $user;
        } else return false;

    }

    /**
     * Gets the current logged in User
     * @return User
     */
    public static function  current()
    {
        $user = new User();
        $user->id = Session::get('user_id');
        $user->givenName = Session::get('givenName');

        return $user;
    }

    public function is_guest()
    {
        return !isset($this->id);
    }

}
