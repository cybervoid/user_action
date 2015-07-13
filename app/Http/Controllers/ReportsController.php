<?php namespace App\Http\Controllers;

use App\Services\Reports;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getReport(Request $req)
    {
        $reportType = $req->route('reportType');
        $name = $req->route('name');

        if ($reportType == 'newhire')
        {
            $filePath = \Config::get('app.newHireReportsPath') . $name;
        }

        if ($reportType == 'payroll')
        {
            $filePath = \Config::get('app.payrollReportsPath') . $name;
        }

        if ($reportType == 'separation')
        {
            $filePath = \Config::get('app.separationReportsPath') . $name;
        }


        $content = Reports::getReport($filePath);

        return new Response($content, Response::HTTP_OK, ["content-type" => "application/pdf",
            "content-length" => filesize($filePath), "content-disposition" => "attachment; filename=\"$name\""]);
    }

}