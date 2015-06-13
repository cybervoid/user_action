@extends('exportTemplate')


@section('content')


<p class="bold" >NEW HIRE</p ><p class="bold" >EMPLOYEE ACTION FORM</p ></div>

<p ><span class="bold" >Name: </span >{{ $req['name'] }} {{ $req['lastName'] }}</p >


<table border="0" width="100%" >
    <tr >
        <td ><p ><span class="bold" >Department/ Dept Code: </span >{{ $req["department"] }}</p ></td >
        <td ><p ><span class="bold" >Employee ID #: </span >{{ $req["employee"] }}</p ></td >
        <td ><p ><span class="bold" >Date of Birth: </span >{{ $req["birthDate"] ?: "-" }}</p ></td >
    </tr >
</table >

<table border="0" width="100%" >
    <tr >
        <td ><p ><span class="bold" >New Hire Title: </span >{{ $req["title"] }}</p ></td >
        <td ><p ><span class="bold" >Company: </span >{{ $req["company"] }}</p ></td >
        <td ><p ><span class="bold" >Reports to (Name/Title): </span >{{ $req["manager"] }}</p ></td >
    </tr >
</table >

<br >
<hr >


<br ><br >
<table border="0" width="100%" >
    <tr valign="top" >
        <td ><span class="bold" >Employee New Hire Status:</span >
            <ul >
                <li >{{ $req["hireStatus"] }}</li >

                @if($req["exepmtion"]!="empty")
                <li > {{ $req["exepmtion"] }}</li >
                @endif
            </ul >
        </td >
        <td >

            <span class="bold" >Hire Date: </span >{{ $req["startDate"] }}<br ><span class="bold" >(1 and 16th where applicable)<span >
                    @if($req["benefitDate"]!="")
    <p ><span class="bold" >Benefits Effective Date: </span >{{ $req["benefitDate"] }}<br ><span class="bold" >(Medical, Dental, FSA) 1st of the month</span >
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
        <td colspan="2" align="right" ><span class="bold" >Date:</span > {{ $req["payrollDate"] }}<br ><span
                class="bold" >(semi-monthly to reflect 1st or 16th of the month)</span ></td >
    <tr >
        <td colspan="3" >&nbsp;</td >
    </tr >
    <tr align="center" >
        <td >
            <span class="bold" >Salary:</span > $ {{ $req["salary"] ?: 'TBD'}}

            @if($req["salaryType"]!="")
            {{$req["salaryType"] }}
            @else
            @if($req["salary"]!="")
            (Salary type TBD)
            @endif
            @endif
        </td >

        <td >
            @if($req["salesLevel"]!="")
            <span class="bold" >Sales Level:</span > {{ $req["salesLevel"] }}
            @endif
        </td >
        <td ><span class="bold" >Bonus:</span >
            @if($req["bonus"]!="")
            {{ $req["bonus"] }}
            @else -
            @endif

        </td >

        <td >
            @if($req["trans"]!="")
            <span class="bold" >Transportation Allowance: </span >

            {{ $req["trans"] }}
            @else
            -
            @endif
        </td >

    </tr >
</table ><br style="clear: left" ><br >
<hr >
<span class="bold" >Employee Benefits Section: </span >
<p ><span >HRB Entry Date: {{ $req["HRB"] }}</span ></p ><br >
<p >


    @if($req["payrollComments"]!="")
<hr ><span class="bold" >Comments/Notes: </span >
{{ $req["payrollComments"] }}
@endif


</p></body></html>

@endsection