<?php namespace App\Services;

/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Reports
{


    static public function escapeReportName($param)
    {
        $text = str_replace("’", '', $param);
        $text = str_replace("'", '', $text);

        return $text;
    }

    static public function generateReport($reportName, $location, $reportType, $req)
    {

        $myFile = storage_path() . "/export.html";
        $toPDF = fopen($myFile, "w+");


        // todo removed $req->url() add it to newhire and separation in the $req param
        //get the domain so I can load the image on the PDF
        $parse = parse_url($req['url']);

        //var_dump($req);
        //echo 'pepe: ' . count($req['changes']);
        //die;


        //todo removed $req->request->all() frin tge $req param, update newHire and separation
        $myView = view($reportType . 'ToPDF', ['req' => $req,
            'server' => $parse['scheme'] . '://' . $parse['host'] . '/',]);

        if (!fwrite($toPDF, $myView))
        {
            return false;
        }
        fclose($toPDF);


        if (env('APP_ENV') == 'windowsLocal')
        {
            $wkhtmltopdf = '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe"';
        }
        else
        {
            $wkhtmltopdf = env('wkhtmltopdf');
        }

        exec($wkhtmltopdf . ' --margin-top 5 --margin-bottom 5' . ' ' . $myFile . ' ' . '"' . $location . $reportName . '"', $returnvar);

    }

    /**
     * Transfer the report so the user can download it
     *
     * @param Request $req
     *
     * @return Response
     */
    static public function loadReport($filePath)
    {

        return file_get_contents($filePath);

    }

    /**
     * Show the new hire form
     *
     * @return Response
     */
    public function index()
    {

        $user = User::current();

        return view('separation', ['user' => $user]);

    }
}