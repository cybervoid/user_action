<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ActiveDirectory extends Controller
{

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

    public static function getEmail($email)
    {

        // fetch the info from AD
        $ldap = ActiveDirectory::ldap_MyConnect();

        $attributes = array('dn', 'title', 'givenname', 'sn', 'manager', 'company', 'department', "memberOf",
            'samaccountname', 'mail');

        if (!$ldap)
        {
            return false;
        }

        $result = ldap_search($ldap, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "mail={$email}", $attributes);

        return ldap_get_entries($ldap, $result);

    }


    private static function lookupUser($param)
    {

        // fetch the info from AD
        $ldap = ActiveDirectory::ldap_MyConnect();
        $attributes = array('givenname', 'sn', 'mail');

        if (!$ldap)
        {
            return false;
        }

        $result = ldap_search($ldap, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "(|(givenname={$param})(sn={$param}))", $attributes);

        return ldap_get_entries($ldap, $result);

    }

    public function autocomplete(Request $req)
    {

        $consult = $this->lookupUser($req->request->get('term') . '*');

        $result = "[";

        $first = true;
        for ($i = 0; $i < $consult["count"]; $i++)
        {

            //  if (isset($consult[$i]["givenname"][0])) echo '<p>'.$consult[$i]["givenname"][0] . ' ' . $consult[$i]["sn"][0] .'</p>';
            if (isset($consult[$i]["givenname"][0]) && isset($consult[$i]["sn"][0]) && isset($consult[$i]["mail"][0]))
            {
                if (preg_match("/@illy.com/", $consult[$i]["mail"][0]))
                {
                    if ($first)
                    {
                        $result .= '{ "label": "' . $consult[$i]["givenname"][0] . ' ' . $consult[$i]["sn"][0] . '", "value": "' . $consult[$i]["mail"][0] . '" }';
                        $first = false;
                    }
                    else
                    {
                        $result .= ',{ "label": "' . $consult[$i]["givenname"][0] . ' ' . $consult[$i]["sn"][0] . '", "value": "' . $consult[$i]["mail"][0] . '" }';
                    }
                }
            }


        }

        $result .= "]";

        return new Response($result, 200, ['content-type' => 'application/json']);

    }

}