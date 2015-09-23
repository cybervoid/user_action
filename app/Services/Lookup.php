<?php namespace app\Services;

/**
 * @class Lookup
 */

use App\Services\ActiveDirectory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Lookup
{

    static public function lookupUser(Request $req)
    {

        $email = $req->request->get('email');

        if (!preg_match("/@illy.com/", $email))
        {
            $email = $email . '@illy.com';
        }
        $email = preg_replace('/\s+/', '', $email);


        if (env('APP_STATUS') == 'offline')
        {
            //$entry = '{"count":1,"0":{"sn":{"count":1,"0":"Gil"},"0":"sn","title":{"count":1,"0":"IT Infrastructure Engineer & Support"},"1":"title","givenname":{"count":1,"0":"Rafael"},"2":"givenname","memberof":{"count":15,"0":"CN=SlideShow_SecurityGrp_NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","1":"CN=HR-Tool,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","2":"CN=Wordpress-editor,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","3":"CN=si_infra_all,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM","4":"CN=RoomUsersUSA,OU=Rooms,OU=New York City,OU=North America,DC=ILLY-DOMAIN,DC=COM","5":"CN=VNC Admin,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM","6":"CN=PC Admins,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM","7":"CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","8":"CN=Report ServiceDesk IC Nord America,CN=Users,DC=ILLY-DOMAIN,DC=COM","9":"CN=Finance NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","10":"CN=VPN illy,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM","11":"CN=Marketing NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","12":"CN=Information Technology NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","13":"CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","14":"CN=Wifi Employees,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM"},"3":"memberof","department":{"count":1,"0":"IT"},"4":"department","company":{"count":1,"0":"illy caff\u00e8 North America, Inc."},"5":"company","samaccountname":{"count":1,"0":"gilra"},"6":"samaccountname","mail":{"count":1,"0":"Rafael.Gil@illy.com"},"7":"mail","manager":{"count":1,"0":"CN=Roy Forster,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM"},"8":"manager","count":9,"dn":"CN=Rafael Gil,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM"}}';


            $offline["givenname"] = 'Rafael';
            $offline["sn"] = 'Gil';
            $offline["mail"] = $req->request->get('email');
            $offline["department"] = 'Information Technology';

            $offline["title"] = 'Infrastructure Engineer';


            $offline["company"] = 'illy caffè North America, Inc.';


            $offline["telephonenumber"] = '+1 914 253 4562';

            $offline["mobile"] = '+1 914 420 3700';


            $offline["sAMAccountName"] = 'gilra';


            $offline["manager"] = 'Roy Forster';
            $offline["managerEmail"] = 'roy.forster@illy.com';


        }
        else
        {
            $ad = ActiveDirectory::get_connection();
            $entry = $ad->getEmail($email);
        }

        //$entry = ActiveDirectory::getEmail($email);

        //$ad = ActiveDirectory::get_connection();
        //$entry = $ad->getEmail($email);


        if (isset($entry))
        {
            $fromAD["givenname"] = $entry[0]["givenname"][0];
            $fromAD["sn"] = $entry[0]["sn"][0];
            $fromAD["mail"] = $req->request->get('email');

            if (isset($entry[0]["department"][0]))
            {
                $fromAD["department"] = $entry[0]["department"][0];
            }
            if (isset($entry[0]["title"][0]))
            {
                $fromAD["title"] = $entry[0]["title"][0];
            }
            if (isset($entry[0]["company"][0]))
            {
                $fromAD["company"] = $entry[0]["company"][0];
            }


            if (isset($entry[0]["telephonenumber"][0]))
            {
                $fromAD["telephonenumber"] = $entry[0]["telephonenumber"][0];
            }
            if (isset($entry[0]["mobile"][0]))
            {
                $fromAD["mobile"] = $entry[0]["mobile"][0];
            }


            $fromAD["sAMAccountName"] = $entry[0]["samaccountname"][0];
            $fromAD["mobile"] = (isset($entry[0]["mobile"][0]) ? $entry[0]["mobile"][0] : '');
            $fromAD["telephonenumber"] = (isset($entry[0]["telephonenumber"][0]) ? $entry[0]["telephonenumber"][0] :
                '');

            // get manager name and email
            if (isset($entry[0]['manager'][0]))
            {

                $managerInfo = $ad->getManager($entry[0]['manager'][0]);
                $fromAD["manager"] = $managerInfo[0]['givenname'][0] . ' ' . $managerInfo[0]['sn'][0];
                $fromAD["managerEmail"] = $managerInfo[0]['mail'][0];
            }


            // get the group info
            if (isset($entry[0]["memberof"]["count"]) > 0)
            {

                //create arry with user's groups
                for ($i = 0; $i < $entry[0]["memberof"]["count"]; $i++)
                {
                    $fromAD["groups"][] = substr($entry[0]["memberof"][$i], 3, strpos($entry[0]["memberof"][$i], ',') - 3);

                }
            }
        }

        if (env('APP_STATUS') == 'offline')
        {
            $response = new Response(json_encode($offline), 200, ['Content-Type' => 'application/json']);
        }
        else
        {
            $response = new Response(json_encode($fromAD), 200, ['Content-Type' => 'application/json']);
        }

        return $response;


    }
}