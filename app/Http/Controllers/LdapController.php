<?php namespace App\Http\Controllers;

use App\Services\ActiveDirectory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LdapController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function autocomplete(Request $req)
    {

        if (env('APP_STATUS') == 'offline')
        {
            $result = '[{"label":"Rafael Gil","value":"Rafael.Gil@illy.com"}]';
        }
        else
        {
            $ad = ActiveDirectory::get_connection();
            $result = $ad->autocomplete($req);
        }


        return new Response($result, 200, ['content-type' => 'application/json']);
    }
}