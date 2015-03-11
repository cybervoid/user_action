<?php namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Ldap implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    public $id; //sAMAccountName
    public $givenName;
    public $sn;


    public static function ldap_connect()
    {
        $ldap = ldap_connect("ldap://DCUSA2.ILLY-DOMAIN.COM");
        if (!$ldap)
        {
            return ldap_error($ldap);
        }
        else
        {
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldap, LDAP_OPT_SIZELIMIT, 1000); //this is just for speed.
            return $ldap;
        }
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
