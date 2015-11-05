<?php namespace App\Http\Controllers;

/**
 * @class ReportsController
 */

use App\Services\Reports;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


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

        if ($reportType == 'payrollNewHire')
        {
            $filePath = \Config::get('app.payrollNewHireReportsPath') . $name;
        }

        if ($reportType == 'payrollSeparation')
        {
            $filePath = \Config::get('app.payrollSeparationReportsPath') . $name;
        }


        if ($reportType == 'separation')
        {
            $filePath = \Config::get('app.separationReportsPath') . $name;
        }

        if ($reportType == 'change_org_rep')
        {
            $filePath = \Config::get('app.change_org_ReportsPath') . $name;
        }

        $result = Reports::loadReport($filePath);

        return new Response($result, Response::HTTP_OK, ["content-type" => "application/pdf",
            "content-length" => filesize($filePath), "content-disposition" => "attachment; filename=\"$name\""]);


    }
}