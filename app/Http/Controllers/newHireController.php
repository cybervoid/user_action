<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class newHireController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | newHire Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return \App\Http\Controllers\newHireController
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

        return view('newHire', ['user' => $user]);

    }


    private function generateReport($reportName, Request $req)
    {
        $myFile = sys_get_temp_dir() . "\\export.html";
        $toPDF = fopen($myFile, "w");

        //get the domain so I can load the image on the PDF
        $parse = parse_url($req->url());

        $myView = view('newHireToPDF', ['req' => $req->request->all(),
            'server' => $parse['scheme'] . '://' . $parse['host'] . '/',]);


        fwrite($toPDF, $myView);
        fclose($toPDF);
        //convert to pdf
        $error = array();

        exec('"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe" ' . $myFile . ' ' . '"'. storage_path() .'\\reports\\'. $reportName.'"', $error);

    }

    public function add(Request $req)
    {
        $newHireReport = 'Action User Notification-' . $req->request->get('name') . ' ' . $req->request->get('lastName') . '.pdf';
        $this->generateReport($newHireReport, $req);
        //return view('newHireThankYou',[


        if ($req->request->get('employee') == "")
        {
            $req->request->set('employee', 'TBD');
        }

        return view('newHireThankYou', ['name' => $req->request->get('name'),
            'lastName' => $req->request->get('lastName'), 'newHireReport' => $newHireReport,]);
    }

    public function getReport(Request $req)
    {
        $name= $req->route('name');
        $filePath = storage_path() . "/reports/$name";
        $content = file_get_contents($filePath);

        return new Response($content, Response::HTTP_OK, [
            "content-type" => "application/pdf",
            "content-length" => filesize($filePath),
            "content-disposition" => "attachment; filename=\"$name\""
        ]);
    }

}
