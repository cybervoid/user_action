<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Reports extends Controller
{

    /**
     * Prepare email basic params to send email
     *
     * @param $reportName
     * @param $location
     * @param Request $req
     *
     *
     * @internal param int $id
     * @return Response
     */


    public function __construct()
    {
        $this->middleware('auth');
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


    static public function generateReport($reportName, $location, $reportType, Request $req)
    {

        $myFile = sys_get_temp_dir() . "\\export.html";
        $toPDF = fopen($myFile, "w");

        //get the domain so I can load the image on the PDF
        $parse = parse_url($req->url());

        $myView = view($reportType . 'ToPDF', ['req' => $req->request->all(),
            'server' => $parse['scheme'] . '://' . $parse['host'] . '/',]);


        fwrite($toPDF, $myView);
        fclose($toPDF);
        //convert to pdf
        $error = array();

        exec(\Config::get('app.pdfCreator') . ' ' . $myFile . ' ' . '"' . $location . $reportName . '"', $error);

    }

    /**
     * Transfer the report so the user can download it
     *
     * @param Request $req
     *
     * @return Response
     */
    static public function getReport(Request $req)
    {

        $name = $req->route('name');
        $reportType = $req->route('reportType');

        if ($reportType == 'newhire')
        {
            $filePath = \Config::get('app.newHireReportsPath') . $name;
        }

        if ($reportType == 'separation')
        {
            $filePath = \Config::get('app.separationReportsPath') . $name;
        }


        $content = file_get_contents($filePath);

        //echo 'rafag';
        //die;

        /*
        return new Response($content, Response::HTTP_OK, ["content-type" => "application/pdf",
            "content-length" => filesize($filePath), "content-disposition" => "inline; filename=\"$name\""]);
        */

        return new Response($content, Response::HTTP_OK, ["content-type" => "application/pdf",
            "content-length" => filesize($filePath), "content-disposition" => "attachment; filename=\"$name\""]);

    }
}