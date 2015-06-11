@extends('exportTemplate')


@section('content')


<p class="bold" >NEW HIRE</p ><p class="bold" >EMPLOYEE ACTION FORM</p >

<p ><span class="bold" >Name: </span >{{ $req['name'] }} {{ $req['lastName'] }}</p >


<table border="0" width="100%" >
    <tr align="center" >
        <td >
            <p ><span class="bold" >Department/ Dept Code: </span >'. $req["department"] .'</p ></td >

        if($req["employee"]=="") $req["employee"] = 'TBD
        <td ><p ><span class="bold" >Employee ID #: </span >'. $req["employee"] .'</p ></td >
        <td ><p ><span class="bold" >Date of Birth: </span >'. $req["birthDate"] .'</p ></td >
    </tr >
</table >


<p ><span class="bold" >New Hire Title: </span >'. $req["title"] .'</p >
<p ><span class="bold" >Reports to (Name/Title): </span >'. $req["manager"] .'</p >
<br >
<hr >


<br ><br >
<table border="0" width="100%" >
    <tr align="center" valign="top" >
        <td ><span class="bold" >Employee New Hire Status:</span >

            <ul >
                <li >'.$req["hireStatus"].'</li >
                if($req["exepmtion"]!="empty"){
                <li >' . $req["exepmtion"] . '</li >
                }
            </ul >


            $body .='
        </td >
        <td ><span class="bold" >Hire Date: </span >' . $req["startDate"] . '<br ><span class="bold" >(1 and 16th where applicable)<span >
    <p ><span class="bold" >Benefits Effective Date: </span >'. $req["benefitDate"] .'<br ><span class="bold" >(Medical, Dental, FSA) 1st of the month</span >
    </p ></td >

    </tr >
</table >


<br style="clear: left" ><br ><span class="bold" >following 30 days of employment:</span >
<hr >

<table border="0" width="100%" >
    <tr >
        <td ><span class="bold" >Payroll/Salary:</span ></td >
        <td colspan="2" align="right" ><span class="bold" >Date:</span > '. $req["payrollDate"] .'<br ><span
                class="bold" >(semi-monthly to reflect 1st or 16th of the month)</span ></td >
    <tr >
        <td colspan="3" >&nbsp;</td >
    </tr >
    <tr align="center" >
        <td >$ ' . $req["salary"] . " " . $req["salaryType"] . '</td >
        <td >Sales Level: ' . $req["salesLevel"] . '</td >
        <td ><span class="bold" >Bonus:</span >
            if($req["bonus"]!=""){
            $body .= $req["bonus"];
            } else -

        </td >

        <td ><span class="bold" >Transportation Allowance: </span >
            if($req["trans"]!=""){
            $body .= $req["trans"];

            } else -

        </td >

    </tr >
</table ><br style="clear: left" ><br >
<hr >
<span class="bold" >Employee Benefits Section: </span >
<p ><span >HRB Entry Date: '. $req["HRB"] .'</span ></p ><br >
<p >
<hr ><span class="bold" >Comments/Notes: </span >


if($req["payrollComments"]!=""){
$body .= $req["payrollComments"];
} else -

<table border="0" width="50%" align="center" >
    <tr align="center" >
        <td align="left" >
            <span class="bold" >Printed name: Maren Gizicki</span ></td >
        <td align="right" ><span class="bold" >Date: ' . date('m-d-Y') . '<br ><br ><span >_____________________<br >Signature</span ></span >
        </td >
    </tr >
</table >


</p></body></html>

@endsection