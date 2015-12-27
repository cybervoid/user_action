@extends('exportTemplate')


@section('content')


<p class="bold" >NEW HIRE</p ><p class="bold" >EMPLOYEE ACTION FORM</p ></div>

<p ><span class="bold" >Name: </span >{{ $req['newH']['name'] }} {{ $req['newH']['lastName'] }}</p >


<table border="0" width="100%" >
    <tr >
        <td ><p ><span class="bold" >Department/ Dept Code: </span >{{ $req['newH']["department"] }}</p ></td >
        <td ><p >
                <span class="bold" >Employee ID #: </span >{{ $req['newH']["employee"]!='' ? $req['newH']["employee"]:'TBD' }}
            </p >
        </td >
        <td ><p ><span class="bold" >Date of Birth: </span >{{ $req['newH']["birthDate"] ?: "-" }}</p ></td >
    </tr >
</table >

<table border="0" width="100%" >
    <tr >
        <td ><p ><span class="bold" >New Hire Title: </span >{{ $req['newH']["title"] }}</p ></td >
        <td ><p ><span class="bold" >Company: </span >{{ $req['newH']["company"] }}</p ></td >
        <td ><p ><span class="bold" >Reports to (Name/Title): </span >{{ $req['newH']["manager"] }}</p ></td >
    </tr >
</table >

<br >
<hr >


<br ><br >
<table border="0" width="100%" >
    <tr valign="top" >
        <td ><span class="bold" >Employee New Hire Status:</span >
            <ul >
                <li >{{ $req['newH']["hireStatus"] }}</li >

                @if($req['newH']["exepmtion"]!="empty")
                    <li > {{ $req['newH']["exepmtion"] }}</li >
                @endif
            </ul >
        </td >
        <td >

            <span class="bold" >Hire Date: </span >{{ $req['newH']["startDate"] }}<br ><span class="bold" >(1 and 16th where applicable)<span >
                    @if($req['newH']["benefitDate"]!="")
                        <p ><span class="bold" >Benefits Effective Date: </span >{{ $req['newH']["benefitDate"] }}
                            <br ><span class="bold" >(Medical, Dental, FSA) 1st of the month</span >
    </p >
                    @endif
        </td >

    </tr >
</table >


<br style="clear: left" ><br ><span class="bold" >following 30 days of employment:</span >
<hr >

<table border="0" width="100%" >
    <tr >
        <td ><span class="bold" >Payroll/Salary:</span ></td >
        <td colspan="2" align="right" ><span class="bold" >Date:</span > {{ $req['newH']["payrollDate"] }}<br ><span
                class="bold" >(semi-monthly to reflect 1st or 16th of the month)</span ></td >
    <tr >
        <td colspan="3" >&nbsp;</td >
    </tr >
    <tr align="center" >
        <td >
            <span class="bold" >Salary:</span > $ {{ $req['newH']["salary"] ?: 'TBD'}}

            @if($req['newH']["salaryType"]!="")
                {{$req['newH']["salaryType"] }}
            @else
                {{$req['newH']["salary"]!='' ? $req['newH']["salary"]:'(Salary type TBD)' }}

            @endif
        </td >

        <td >
            <span class="bold" >Sales Level:</span >
            {{$req['newH']["salesLevel"]!='' ? $req['newH']["salesLevel"]:'-' }}
        </td >
        <td ><span class="bold" >Bonus</span >
            {{$req['newH']["bonus"]!='' ? $req['newH']["bonus"]:'-' }}

        </td >

        <td >
            <span class="bold" >Transportation Allowance: </span >
            {{$req['newH']["trans"]!='' ? $req['newH']["trans"]:'-' }}

        </td >

    </tr >
</table ><br style="clear: left" ><br >
<hr >
<span class="bold" >Employee Benefits Section: </span >
<p ><span >

        HRB Entry Date:
        {{$req['newH']["HRB"]!='' ? $req['newH']["HRB"]:'-' }}
    </span ></p ><br >
<p >


    @if($req['newH']["payrollComments"]!="")
        <span class="bold" ><hr >Comments/Notes: </span > {{$req['newH']["payrollComments"]}}
@endif


</p></body></html>

@endsection