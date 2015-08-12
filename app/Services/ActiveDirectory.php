<?php namespace App\Services;

/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ActiveDirectory
{
    private static $conn;

    private function __construct() { }

    public static function get_connection()
    {
        if (!ActiveDirectory::$conn)
        {
            ActiveDirectory::$conn = ldap_connect("ldap://" . env('LDAP_HOST'));

            if (!ActiveDirectory::$conn)
            {
                error_log(ldap_error(ActiveDirectory::$conn));

                return null;
            }
            else
            {
                $adUserName = env('LDAP_USER');
                $adPassword = env('LDAP_PASSWORD');
                $adDomain = env('LDAP_DOMAIN');

                ldap_set_option(ActiveDirectory::$conn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option(ActiveDirectory::$conn, LDAP_OPT_REFERRALS, 0);
                ldap_set_option(ActiveDirectory::$conn, LDAP_OPT_SIZELIMIT, 1000); //this is just for speed.
                if (!ldap_bind(ActiveDirectory::$conn, $adUserName . "@" . $adDomain, $adPassword))
                {
                    return null;
                }
            }
        }

        return new ActiveDirectory();
    }

    public function disableUser($entry)
    {

        $dn = $entry[0]["dn"];
        $ac = $entry[0]["useraccountcontrol"][0];
        $disable = ($ac | 2); // set all bits plus bit 1 (=dec2)
        $userdata = array();
        $userdata["useraccountcontrol"][0] = $disable;
        return ldap_modify(static::$conn, $dn, $userdata); //change state

    }

    public function removeFromGroups($groups, $dn)
    {

        if (!isset($dn))
        {
            return false;
        }

        $group_info['member'] = $dn;

            // get group dn
            foreach ($groups as $item)
            {
                $result = ActiveDirectory::query("sAMAccountName={$item}");
                $group_dn = $result[0]['dn'];
                $errorFound = @ldap_mod_del(static::$conn, $group_dn, $group_info);
            }

            return $errorFound;

        $result = false;
    }

    public static function query($search)
    {
        // fetch the info from AD
        $attributes = array('dn', 'title', 'givenname', 'sn', 'manager', 'company', 'department', "memberOf",
            'samaccountname', 'mail');

        $result = ldap_search(static::$conn, "OU=North America,DC=ILLY-DOMAIN,DC=COM", $search, $attributes);

        return ldap_get_entries(static::$conn, $result);
    }

    public function removeUserInfo($entry)
    {

        $dn = $entry[0]["dn"];

        if(isset($entry[0]["description"])) $userdata['Description']= array();
        if(isset($entry[0]["title"])) $userdata['title']= array();
        if(isset($entry[0]["manager"])) $userdata['manager']= array();

        if (isset($userdata)) return @ldap_mod_del(static::$conn, $dn, $userdata);


    }

    public function getEmail($email)
    {
        $attributes = array('dn', 'title', 'givenname', 'sn', 'manager', 'company', 'department', "memberOf",
            'samaccountname', 'mail', 'mobile', 'telephoneNumber');

        $result = ldap_search(ActiveDirectory::$conn, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "mail={$email}", $attributes);

        return ldap_get_entries(ActiveDirectory::$conn, $result);

    }

    public function createUserAD(Request $req)
    {
        $name = trim($req->request->get('name'));
        $lastName = trim($req->request->get('lastName'));

        $ldaprecord['cn'] = ucfirst(strtolower($name)) . " " . ucfirst(strtolower($lastName));
        $ldaprecord['givenName'] = ucfirst(strtolower($name));
        $ldaprecord['sn'] = ucfirst(strtolower($lastName));
        $ldaprecord['title'] = ucwords(strtolower($req->request->get('title')));
        $ldaprecord['Description'] = ucwords(strtolower($req->request->get('title')));
        $ldaprecord['sAMAccountName'] = strtolower(substr($lastName, 0, 5) . substr($name, 0, 2));
        $ldaprecord['UserPrincipalName'] = $ldaprecord['sAMAccountName'] . "@ILLY-DOMAIN.COM";
        $ldaprecord['displayName'] = ucfirst(strtolower($lastName)) . " " . ucfirst(strtolower($name));

        $ldaprecord['department'] = $req->request->get('department');
        $ldaprecord['company'] = $req->request->get('company');

        if ($req->request->get('location') == "New York City")
        {
            $ldaprecord['streetAddress'] = "275 Madison Avenue, 31st Floor";
            $ldaprecord['st'] = "NY";
            $ldaprecord['postalCode'] = "10016";
            $ldaprecord['l'] = "New York";
            $ldaprecord['c'] = "US";
        }
        else
        {
            if ($ldaprecord['company'] == 'Espressamente illy')
            {
                $ldaprecord['streetAddress'] = "800 Westchester Avenue, Suite S438";
            }
            else
            {
                $ldaprecord['streetAddress'] = "800 Westchester Avenue, Suite S440";
            }

            $ldaprecord['st'] = "NY";
            $ldaprecord['postalCode'] = "10573";
            $ldaprecord['l'] = "Rye Brook";
            $ldaprecord['c'] = "US";
        }

        $ldaprecord['displayName'] = ucfirst(strtolower($lastName)) . " " . ucfirst(strtolower($name));

        if ($req->request->get('location_Other') != '')
        {
            $ldaprecord['physicalDeliveryOfficeName'] = $req->request->get('location_Other');
        }
        else
        {
            $ldaprecord['physicalDeliveryOfficeName'] = $req->request->get('location');
        }
        $ldaprecord['telephoneNumber'] = "+1 914 253 4";
        $ldaprecord['UserAccountControl'] = "544";
        $ldaprecord['objectclass'][0] = 'top';
        $ldaprecord['objectclass'][1] = 'person';
        $ldaprecord['objectclass'][2] = 'organizationalPerson';
        $ldaprecord['objectclass'][3] = 'user';
        $ldaprecord['mail'] = strtolower($name . "." . $lastName) . "@illy.com";

        //search manager DN by email
        if ($req->request->get('managerEmail') != '')
        {
            $consult = ldap_search(static::$conn, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "mail={$req->request->get('managerEmail')}", ['distinguishedName']);
            $managerInfo = ldap_get_entries(static::$conn, $consult);
            if (isset($managerInfo[0]['distinguishedname'][0]))
            {
                $ldaprecord["manager"] = $managerInfo[0]['distinguishedname'][0];
            }
        }

        //create the user in the system
        $dn_user = ("CN=" . $ldaprecord['cn'] . ",OU=Users,OU=" . $req->request->get('location') . ",OU=North America,DC=ILLY-DOMAIN,DC=COM");
        @ldap_add(static::$conn, $dn_user, $ldaprecord);

        //define and join user to groups
        $illyGroups['illyusaNorth America'] = 'CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyryebrook'] = 'CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyusa NYC Team'] = 'CN=illy NYC Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illyManagers'] = 'CN=illyusa Managers Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';
        $illyGroups['illySales'] = 'CN=illyusa Sales Team Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM';

        $group_info['member'] = $dn_user;

        $groupsToAdd = $req->request->get('iTDeptEmail');
        if (isset($groupsToAdd))
        {
            foreach ($groupsToAdd as $group)
            {
                @ldap_mod_add(static::$conn, $illyGroups[$group], $group_info);
            }
        }
    }

    public function getManager($manager)
    {
        $consult = ldap_search(static::$conn, $manager, "(objectclass=*)", ['mail', 'sn', 'givenname']);

        return ldap_get_entries(static::$conn, $consult);

    }

    public function lookup_chng_org(Request $req)
    {
        $consult = $this->lookupUser($req->request->get('term') . '*');
        $result = [];
        for ($i = 0; $i < $consult["count"]; $i++)
        {
            if (isset($consult[$i]["givenname"][0]) && isset($consult[$i]["sn"][0]) && isset($consult[$i]["samaccountname"][0]))
            {
                $result[] = array("label" => $consult[$i]["givenname"][0] . ' ' . $consult[$i]["sn"][0],
                    "value" => $consult[$i]["samaccountname"][0]);
            }
        }

        return new Response($result, 200, ['content-type' => 'application/json']);
    }

    private static function lookupUser($param)
    {

        // fetch the info from AD
        $attributes = array('givenname', 'sn', 'mail', 'samaccountname', 'mail');


        $mail = str_replace(' ', '.', $param);

        //$result = ldap_search(static::$conn, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "(&(!(userAccountControl:1.2.840.113556.1.4.803:=2)) (|(givenname={$param})(sn={$param}))  )", $attributes);
        $result = ldap_search(static::$conn, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "(&(!(userAccountControl:1.2.840.113556.1.4.803:=2)) ( |(|(givenname={$param})(sn={$param})) (mail={$mail}))  )", $attributes);
        return ldap_get_entries(static::$conn, $result);

    }

    public function autocomplete(Request $req)
    {

        $consult = $this->lookupUser('*' . $req->request->get('term') . '*');

        $result = [];
        for ($i = 0; $i < $consult["count"]; $i++)
        {
            if (isset($consult[$i]["givenname"][0]) && isset($consult[$i]["sn"][0]) && isset($consult[$i]["mail"][0]))
            {
                if (preg_match("/@illy.com/", $consult[$i]["mail"][0]))
                {
                    $result[] = array("label" => $consult[$i]["givenname"][0] . ' ' . $consult[$i]["sn"][0],
                        "value" => $consult[$i]["mail"][0]);
                }
            }
        }

        return json_encode($result);
    }

    public function validateLogin($userName, $password)
    {
        $attributes = array('givenname', 'sn', 'sAMAccountName');
        $result = ldap_search(static::$conn, "OU=North America,DC=ILLY-DOMAIN,DC=COM", "(&(sAMAccountName={$userName})(memberOf=CN=HR-Tool,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM))", $attributes);
        $entry = ldap_get_entries(static::$conn, $result);

        if (isset($entry[0]["count"]))
        {
            //verify the password
            if (@$bind = ldap_bind(static::$conn, $userName . "@" . env('LDAP_DOMAIN'), $password))
            {
                return $entry;
            } // else password incorrect

            ldap_close(static::$conn);
        }
        else
        {
            return false;
        } // username incorrect or not allowed to login

    }

    public function getsamaccountname($username)
    {
        $attributes = array('dn', 'useraccountcontrol', 'Description', 'title', 'manager');
        $myDN = "OU=North America,DC=ILLY-DOMAIN,DC=COM";

        $txtSearch = "samaccountname={$username}";

        $result = ldap_search(static::$conn, $myDN, $txtSearch, $attributes);

        return ldap_get_entries(static::$conn, $result);
    }

    private function __clone() { }

    private function __wakeup() { }

}