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

        $ad = ActiveDirectory::get_connection();
        $entry = $ad->getEmail($email);


        if (env('APP_STATUS') == 'offline')
        {

            $response = new Response(json_encode($entry), 200, ['Content-Type' => 'application/json']);
        }
        else
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
            $response = new Response(json_encode($fromAD), 200, ['Content-Type' => 'application/json']);
        }

        return $response;


    }
}