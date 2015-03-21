<?php namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use League\Flysystem\Exception;

class Ldap implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    public $id; //sAMAccountName
    public $givenName;
    public $sn;


    public static function ldap_MyConnect()
    {
        $ldap = ldap_connect("ldap://DCUSA2.ILLY-DOMAIN.COM");
        if (!$ldap)
        {
            error_log(ldap_error($ldap));
            return null;
        }
        else
        {
            $adUserName= \Config::get('app.adUserName');
            $adPassword= \Config::get('app.adPassword');
            $adDomain= \Config::get('app.adDomain');


            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldap, LDAP_OPT_SIZELIMIT, 1000); //this is just for speed.
            if(! ldap_bind($ldap, $adUserName . "@" . $adDomain, $adPassword)) return null;
            return $ldap;
        }
    }


    /**
     * Gets the current logged in User
     *
     * @param $userName
     * @param $password
     *
     * @internal param string $txtSearch
     * @internal param string $myDN
     * @internal param string $query
     *
     * @return User
     */
    public static function  ldap_login_validate($userName, $password)
    {
        $ldap = self::ldap_MyConnect();

        $attributes = array( 'givenname', 'sn', 'sAMAccountName');
        if (!$ldap){ return false; }
        $result = ldap_search($ldap, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "(&(sAMAccountName={$userName})(memberOf=CN=HR-Tool,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM))" , $attributes);
        $entry = ldap_get_entries($ldap, $result);

        if (isset($entry[0]["count"])){
            //verify the password

            if (@$bind = ldap_bind($ldap, $userName."@ILLY-DOMAIN.COM", $password)){
                return $entry;
            } // else password incorrect

            ldap_close($ldap);
        } else return false; // username incorrect or not allowed to login



    }


    /**
     * Gets the current logged in User
     *
     * @param string $txtSearch
     * @param string $myDN
     * @param string $query
     *
     * @return User
     * $consult = ldapAccess("(objectclass=*)",$row[0]['manager'][0] , "new_read");
     */
    public static function  ldap_query($txtSearch, $myDN, $query = "")
    {

        $ldap= ldap_MyConnect;
        if ($bind = ldap_bind($ldap, "adm_gilra@ILLY-DOMAIN.COM", "R4f43lg1l"))
        {
            $attributes = array('dn', 'title', 'givenname', 'sn', 'manager', 'department', 'memberOf', 'mail',
                'sAMAccountName');
            if ($myDN == '')
            {
                $myDN = "OU=North America,DC=ILLY-DOMAIN,DC=COM";
            }
            $result = ldap_search($ldap, $myDN, $txtSearch, $attributes);
            $entry = ldap_get_entries($ldap, $result);

        }

        ldap_close($ldap);

        return $entry;

        /*
        $user = new User();
        $user->id = Session::get('user_id');
        $user->givenName = Session::get('givenName');
        return $user;
        */
    }

}
