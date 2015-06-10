<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */





class ActiveDirectory extends Controller {

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
            $adUserName = \Config::get('app.adUserName');
            $adPassword = \Config::get('app.adPassword');
            $adDomain = \Config::get('app.adDomain');


            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldap, LDAP_OPT_SIZELIMIT, 1000); //this is just for speed.
            if (!ldap_bind($ldap, $adUserName . "@" . $adDomain, $adPassword))
            {
                return null;
            }

            return $ldap;
        }
    }
}