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

    {{--<div>--}}
    {{--<img src="images/illy-watermark.png">--}}
    {{--</div>--}}

    <div class="centerObj remark page_title" ><p >NEW HIRE</p ></div >


    <p ><span class="remark" >Name: </span >{{ $req['newH']['name'] }} {{ $req['newH']['lastName'] }}</p >

    @if ($req['newH']["buddy"]!='')
        <p ><span class="remark" >Buddy Name: </span >{{ $req['newH']["buddy"] }}</p >
@endif


<table width="100%" >
    <tr >
        <td width="left" ><span class="remark" >Company: </span > {{ $req['newH']["company"] }}</td >
        <td width="left" ><span class="remark" >Department: </span > {{ $req['newH']["department"] }}</td >

        @if (isset($req['newH']["manager"]))
            <td width="right" ><span class="remark" >Manager: </span > {{ $req['newH']["manager"] }}</td >
        @endif
    </tr >
</table >


    <table width="100%" border="0" >
        <tr >
            <td width="40%" >
                @if (isset($req['newH']["title"]))
                    <p ><span class="remark" >Title: </span >{{ $req['newH']["title"] }}</p >
                @endif
            </td >
            <td width="30%" >
                @if (($req['newH']["associate_class"])!='')
                    <p ><span class="remark" >Associate Classification: </span >{{ $req['newH']["associate_class"] }}
                    </p >
                @endif
            </td >
            <td align="30%" >
                @if (($req['newH']["payrollType"])!='')
                    <p ><span class="remark" >Payroll Type: </span >{{ $req['newH']["payrollType"] }}</p >
                @endif
            </td >
        </tr >
    </table >




    <p ><span class="remark" >Employee #: </span >
        @if($req['newH']["employee"]!='')
            {{ $req['newH']["employee"] }}
        @else TBD
        @endif
    </p >


<table width="100%" >
    <tr >
        <td width="left" ><span class="remark" >Start Date: </span > {{ $req['newH']["startDate"] }}</td >

        @if (isset($req['newH']["location_Other"]))
            <td width="center" >
                <span class="remark" >Location: </span > {{ $req['newH']["location"] }} {{ $req['newH']["location_Other"] }}</td >
        @endif

        <td width="right" >

            @if($req['newH']["hireStatus"]!='')
                <span class="remark" >Hire Status: </span > {{ $req['newH']["hireStatus"] }}
            @endif
        </td >
    </tr >
</table >


    @if (isset($req['newH']["iTDeptEmail"]))

<p ><span class="remark" >IT Department Checklist: Rafael Gil and Service Desk</span ></p >

<p >Standard notification request includes on all computers/laptops: OfficeSuite, Adobe Acrobat Pro, CCleaner, VPN,
    Efax, Chrome, Firefox, Silverlight, FlashPlayer, Omniform, Skype, Dropbox, VLC Media Player, 7Zip. Outlook, Addition
    to distributions lists.</p >

<p > All Cellphones will include a link to Hotspot set up.</p >

<p > *Upon user notification request, IT provides customer service to hiring manager and new hire. Hiring managers will
    be contacted before new hire begins.</p >

<p >Laptop needs to be shipped to an outside location, please contact Human Resources Manager for address.
    Computer and or other equipment will be delivered 3 days prior to hire date. An email confirmation notification
    will be sent to Hiring manager, Associate and Human Resources Manager.</p >

<p ><span class="remark" >E-Mail Distribution List:</span ></p >
<ul >


    @foreach($req['newH']["iTDeptEmail"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif

    @if (isset($req['newH']["iTDept"]))

<p ><span class="remark" >Assets:</span ></p >

@if (isset($req['newH']["deliveryDate"]))
    <p >Delivery Date: {{ $req['newH']["deliveryDate"] }}</p >
@endif
<ul >
    @foreach($req['newH']["iTDept"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >

@endif


    <p ><span class="remark" >Specific assets and or functionalities needed: not listed on the User Notification form should be confirmed with hiring manager by IT.<p ></p ><P ></P ></span >
</p >


    @if(isset($req['newH']["application"]))
        <p ><span class="remark" >JDE Setup - IT Team</span ></p >
<ul >
    <li >{{ $req['newH']["application"] }}</li >
</ul >
@endif

    @if(isset($req['newH']["oManager"]))
        <p ><span class="remark" >HQ Office Manager-Suzie Schwab</span ></p >

<ul >
    @foreach($req['newH']["oManager"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif

    @if(isset($req['newH']["newDriver"]))
<p ><span class="remark" >New Driver for Company Vehicle Form-Erik Tellone (new hire notification only) (if applicable)</span ></p >
<ul >
    <li >Form to Hiring Manager</li >
</ul >
@endif


    @if(isset($req['newH']["creditCard"]))
    <p ><span class="remark" >        Finance - Marjorie Guthrie<br >
        (Credit Card and Concur Access Requests) *new hires and separation
</span >
</p >
<ul >
    @foreach($req['newH']["creditCard"] as $item)
    <li >{{ $item }}</li >
    @endforeach
</ul >
@endif


    @if($req['newH']["comments"]!="")
    <br >
    <p ><span class="remark" >SPECIFIC INSTRUCTIONS HERE: </span ></p >
    {{ $req['newH']["comments"] }}
    <p ></p ><br >
@endif


@endsection