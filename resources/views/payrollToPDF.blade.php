@extends('exportTemplate')


@section('content')


<p class="remark" >NEW HIRE</p ><p class="remark" >EMPLOYEE ACTION FORM</p ></div>

<p ><span class="remark" >Name: </span >{{ $req['newH']['name'] }} {{ $req['newH']['lastName'] }}</p >


<table border="0" width="100%" >
    <tr >
        <td ><p ><span class="remark" >Department/ Dept Code: </span >{{ $req['newH']["department"] }}</p ></td >
        <td ><p >
                <span class="remark" >Employee ID #: </span >{{ $req['newH']["employee"]!='' ? $req['newH']["employee"]:'TBD' }}
            </p >
        </td >
        <td ><p ><span class="remark" >Date of Birth: </span >{{ $req['newH']["birthDate"] ?: "-" }}</p ></td >
    </tr >
</table >

<table border="0" width="100%" >
    <tr >
        <td ><p ><span class="remark" >New Hire Title: </span >{{ $req['newH']["title"] }}</p ></td >
        <td ><p ><span class="remark" >Company: </span >{{ $req['newH']["company"] }}</p ></td >
        <td ><p ><span class="remark" >Reports to (Name/Title): </span >{{ $req['newH']["manager"] }}</p ></td >
    </tr >
</table >

<br >
<hr >


<br ><br >
<table border="0" width="100%" >
    <tr valign="top" >
        <td ><span class="remark" >Employee New Hire Status:</span >
            <ul >
                <li >{{ $req['newH']["hireStatus"] }}</li >

                @if($req['newH']["exepmtion"]!="empty")
                    <li > {{ $req['newH']["exepmtion"] }}</li >
                @endif
            </ul >
        </td >
        <td >

            <span class="remark" >Hire Date: </span >{{ $req['newH']["startDate"] }}<br ><span class="remark" >(1 and 16th where applicable)<span >
                    @if($req['newH']["benefitDate"]!="")
                        <p ><span class="remark" >Benefits Effective Date: </span >{{ $req['newH']["benefitDate"] }}
                            <br ><span class="remark" >(Medical, Dental, FSA) 1st of the month</span >
    </p >
                    @endif
        </td >

    </tr >
</table >


<br style="clear: left" ><br ><span class="remark" >following 30 days of employment:</span >
<hr >

<table border="0" width="100%" >
    <tr >
        <td ><span class="remark" >Payroll/Salary:</span ></td >
        <td colspan="2" align="right" ><span class="remark" >Date:</span > {{ $req['newH']["payrollDate"] }}<br ><span
                class="remark" >(semi-monthly to reflect 1st or 16th of the month)</span ></td >
    <tr >
        <td colspan="3" >&nbsp;</td >
    </tr >
    <tr align="center" >
        <td >
            <span class="remark" >Salary:</span > $ {{ $req['newH']["salary"] ?: 'TBD'}}

            @if($req['newH']["salaryType"]!="")
                {{$req['newH']["salaryType"] }}
            @else
                {{$req['newH']["salary"]!='' ? $req['newH']["salary"]:'(Salary type TBD)' }}

            @endif
        </td >

        <td >
            <span class="remark" >Sales Level:</span >
            {{$req['newH']["salesLevel"]!='' ? $req['newH']["salesLevel"]:'-' }}
        </td >
        <td ><span class="remark" >Bonus</span >
            {{$req['newH']["bonus"]!='' ? $req['newH']["bonus"]:'-' }}

        </td >

        <td >
            <span class="remark" >Transportation Allowance: </span >
            {{$req['newH']["trans"]!='' ? $req['newH']["trans"]:'-' }}

        </td >

    </tr >
</table ><br style="clear: left" ><br >
<hr >
<span class="remark" >Employee Benefits Section: </span >
<p ><span >

        HRB Entry Date:
        {{$req['newH']["HRB"]!='' ? $req['newH']["HRB"]:'-' }}
    </span ></p ><br >
<p >


    @if($req['newH']["payrollComments"]!="")
        <span class="remark" ><hr >Comments/Notes: </span > {{$req['newH']["payrollComments"]}}
@endif


</p></body></html>

@endsection