@extends('exportTemplate')


@section('content')


<div class="center" ><p style="font-weight: bold" >USER NOTIFICATION FORM</p >

    <p >Human Resources<br>
        * Transactions to be processed within 48 hours of notification
    </p >

    <p style="font-weight: bold" >NEW HIRE</p ></div >

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



<table width="100%" >
    <tr >
        <td width="left" ><span >Start Date: </span > {{ $req["startDate"] }}</td >

        @if (isset($req["location_Other"]))
            <td width="center" ><span >Location: </span > {{ $req["location"] }} {{ $req["location_Other"] }}</td >
        @endif

        <td width="right" ><span >Hire Status: </span > {{ $req["hireStatus"] }}</td >
    </tr >
</table >


@if (isset($req["iTDeptEmail"]))

    <p ><span >IT Department Checklist: Rafael Gil and Service Desk</span ></p >

    <p >Standard notification request includes on all computers/laptops: OfficeSuite, Adobe Acrobat Pro, CCleaner, VPN,
        Efax, Chrome, Firefox, Silverlight, FlashPlayer, Omniform, Skype, Dropbox, VLC Media Player, 7Zip. Outlook, Addition
        to distributions lists.</p >

    <p > All Cellphones will include a link to Hotspot set up.</p >

    <p > *Upon user notification request, IT provides customer service to hiring manager and new hire. Hiring managers will
        be contacted before new hire begins.</p >

    <p ><span >E-Mail Distribution List:</span ></p >
    <ul >


        @foreach($req["iTDeptEmail"] as $item)
        <li >{{ $item }}</li >
        @endforeach
    </ul >
@endif

@if (isset($req["iTDept"]))
<p ><span >Assets:</span ></p >
<ul>
    @foreach($req["iTDept"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >

@endif


<p ><span >Specific assets and or functionalities needed: not listed on the User Notification form should be confirmed with hiring manager by IT.<p ></p >SPECIFIC INSTRUCTIONS HERE:<P ></P ></span >
</p >


@if(isset($req["oracle"]))
<p ><span >Oracle Specialist Natasha D\'Souza</span ></p >
<ul >
    <li >Oracle Access/Oracle (HR) Number Approval (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)</li >
</ul >
@endif

@if(isset($req["oManager"]))
<p ><span >HQ Office Manager-Suzie Schwab</span ></p >

<ul>
@foreach($req["oManager"] as $item)
<li >{{ $item }}</li >
@endforeach
</ul>
@endif

@if(isset($req["newDriver"]))
<p ><span >New Driver for Company Vehicle Form-Erik Tellone (new hire notification only) (if applicable)</span ></p >
<ul >
    <li >Form to Hiring Manager</li >
</ul >
@endif


@if(isset($req["creditCard"]))
<p ><span >COMPANY CREDIT CARD-Marjorie Guthrie (if applicable)-included in new hires and separation notices</span >
</p >
<ul>
@foreach($req["creditCard"] as $item)
<li >{{ $item }}</li >
@endforeach
</ul>
@endif


@if($req["comments"]!="")
<p ><span >Comments: </span ></p >
{{ $req["comments"] }}
@endif


<table border="0" width="50%" align="center" >
    <tr align="center" >
        <td align="left" >
            <span class="bold" >Printed name: Maren Gizicki</span ></td >
        <td align="right" ><span class="bold" >Date: {{ date('m-d-Y') }}<br ><br ><span >_____________________<br >Signature</span ></span >
        </td >
    </tr >
</table >


@endsection