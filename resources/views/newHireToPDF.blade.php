@extends('exportTemplate')


@section('content')

    <style type="text/css" >
        #watermark {

            color: #d0d0d0;
            font-size: 50pt;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            position: absolute;
            width: 50%;
            height: 50%;
            margin: 0;
            z-index: -1;
            left: 100px;
            top: 100px;
        }
    </style >

    <div id="watermarks" >
        <p >illy caffè North America, Inc.</p >

    </div >
    {{--<div>--}}
    {{--<img src="images/illy-watermark.png">--}}
    {{--</div>--}}

<p style="font-weight: bold" >NEW HIRE</p ></div >

<p ><span >Name: </span >{{ $req['name'] }} {{ $req['lastName'] }}</p >


    @if ($req["buddy"]!='')
        <p ><span >Buddy Name: </span >{{ $req["buddy"] }}</p >
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


    <p ><span >Employee #: </span >
        @if($req["employee"]!='')
            {{ $req["employee"] }}
        @else TBD
        @endif
    </p >


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

<p >Laptop needs to be shipped to an outside location, please contact Human Resources Manager for address.
    Computer and or other equipment will be delivered 3 days prior to hire date. An email confirmation notification
    will be sent to Hiring manager, Associate and Human Resources Manager.</p >

<p ><span >E-Mail Distribution List:</span ></p >
<ul >


    @foreach($req["iTDeptEmail"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif

@if (isset($req["iTDept"]))

<p ><span >Assets:</span ></p >

@if (isset($req["deliveryDate"]))
    <p >Delivery Date: {{ $req["deliveryDate"] }}</p >
@endif
<ul >
    @foreach($req["iTDept"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >

@endif


<p ><span >Specific assets and or functionalities needed: not listed on the User Notification form should be confirmed with hiring manager by IT.<p ></p >SPECIFIC INSTRUCTIONS HERE:<P ></P ></span >
</p >


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

@if(isset($req["newDriver"]))
<p ><span >New Driver for Company Vehicle Form-Erik Tellone (new hire notification only) (if applicable)</span ></p >
<ul >
    <li >Form to Hiring Manager</li >
</ul >
@endif


@if(isset($req["creditCard"]))
    <p ><span >        Finance - Marjorie Guthrie<br >
        (Credit Card and Concur Access Requests) *new hires and separation
</span >
</p >
<ul >
    @foreach($req["creditCard"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif


@if($req["comments"]!="")
<p ><span >Comments: </span ></p >
{{ $req["comments"] }}
@endif


@endsection