@extends('exportTemplate')


@section('content')


<p style="font-weight: bold" >SEPARATION</p ></div >

<p ><span >Name: </span >{{ $req['name'] }} {{ $req['lastName'] }}</p >


@if (isset($req["nickname"]))
<p ><span >Nickname (if applicable): </span >{{ $req["nickname"] }}</p >
@endif


<table width="100%" >
    <tr >
        <td width="left" ><span >Company: </span > {{ $req["company"] }}</td >
        <td width="left" ><span >Department: </span > {{ $req["department"] }}</td >

        @if (isset($req["manager"]))
        <td width="right" ><span >Manager: </span > {{ $req["manager"] }}</td >
        @endif
    </tr >
</table >


@if (isset($req["title"]))
<p ><span >Title: </span >{{ $req["title"] }}</p >
@endif


<p ><span >Employee #: </span >{{ $req["employee"] or 'TBD' }}</p >


<div class="left3" ><span >Separation Date: </span > {{ $req["termDate"] }}</div >
<div class="left3" ><span >Hire Status: </span > {{ $req["hireStatus"] }}</div >
@if (isset($req["location_Other"]))
<div class="left3" ><span >Location: </span > {{ $req["location"] }} {{ $req["location_Other"] }}</div >
@endif


@if (isset($req["iTDeptEmail"]))

<p ><span >IT Department Checklist: Rafael Gil and Service Desk</span ></p >

<p ><span >E-Mail Distribution List:</span ></p >
<ul >


    @foreach($req["iTDeptEmail"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif

@if (isset($req["iTDept"]))
<p ><span >Assets:</span ></p >
<ul >
    @foreach($req["iTDept"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif


@if (isset($req["itComments"]))
<p ><span >Additional instructions for IT:</span ></p >
<p style="margin-left: 22px" >
    {{ $req["itComments"] }}
</p >
@endif


@if(isset($req["oracle"]))
<p ><span >Oracle Specialist Natasha D'Souza</span ></p >
<ul >
    <li >Oracle Access/Oracle (HR) Number Approval (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)</li >
</ul >
@endif

@if(isset($req["oManager"]))
<p ><span >HQ Office Manager-Suzie Schwab</span ></p >

<ul >
    @foreach($req["oManager"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif


@if(isset($req["creditCard"]))
<p ><span >COMPANY CREDIT CARD-Marjorie Guthrie (if applicable)-included in new hires and separation notices</span >
</p >
<ul >
    @foreach($req["creditCard"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif

@if (isset($req["generalComments"]))
<p ><span >Additional instructions for Administration Office:</span ></p >
<p style="margin-left: 22px" >
    {{ $req["generalComments"] }}
</p >
@endif


@endsection