@extends('exportTemplate')


@section('content')


    <p style="font-weight: bold" >SEPARATION</p ></div >

    <p ><span >Name: </span >{{ $req['sep']['name'] }} {{ $req['sep']['lastName'] }}</p >


    @if ($req['sep']["buddy"]!='')
        <p ><span >Buddy Name: </span >{{ $req['sep']["buddy"] }}</p >
    @endif

    <table width="100%" >
        <tr >
            <td width="left" ><span >Company: </span > {{ $req['sep']["company"] }}</td >
            <td width="left" ><span >Department: </span > {{ $req['sep']["department"] }}</td >

            @if (isset($req['sep']["manager"]))
                <td width="right" ><span >Manager: </span > {{ $req['sep']["manager"] }}</td >
            @endif
        </tr >
    </table >


    @if (isset($req['sep']["title"]))
        <p ><span >Title: </span >{{ $req['sep']["title"] }}</p >
    @endif


    <p ><span >Employee #: </span >
        @if($req['sep']["employeeID"]!='')
            {{ $req['sep']["employeeID"] }}
        @else TBD
        @endif
    </p >


    <div class="left3" ><span >Separation Date: </span > {{ $req['sep']["termDate"] }}</div >
    <div class="left3" ><span >Hire Status: </span > {{ $req['sep']["hireStatus"] }}</div >
    @if (isset($req['sep']["location_Other"]))
        <div class="left3" ><span >Location: </span > {{ $req['sep']["location"] }} {{ $req['sep']["location_Other"] }}
        </div >
    @endif


    @if (isset($req['sep']["iTDeptEmail"]))

        <p ><span >IT Department Checklist: Rafael Gil and Service Desk</span ></p >

        <p ><span >E-Mail Distribution List:</span ></p >
        <ul >


            @foreach($req['sep']["iTDeptEmail"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif


    @if (isset($req['sep']["iTDept"]))
        <p ><span >Assets:</span ></p >
        <ul >
            @foreach($req['sep']["iTDept"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif


    @if ($req['sep']["itComments"]!='')
        <p ><span >Additional instructions for IT:</span ></p >
        <p style="margin-left: 22px" >
            {{ $req['sep']["itComments"] }}
        </p >
    @endif


    @if(isset($req['sep']["oracle"]))
        <p ><span >Oracle Specialist Natasha D'Souza</span ></p >
        <ul >
            <li >Oracle Access/Oracle (HR) Number Approval (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)
            </li >
        </ul >
    @endif

    @if(isset($req['sep']["oManager"]))
        <p ><span >HQ Office Manager-Suzie Schwab</span ></p >

        <ul >
            @foreach($req['sep']["oManager"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif


    @if(isset($req['sep']["creditCard"]))
        <p ><span >Finance- (Credit Card and Concur Access Requests) *new hires and separation</span >
        </p >
        <ul >
            @foreach($req['sep']["creditCard"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif

    @if ($req['sep']["generalComments"]!='')
        <p ><span >Additional instructions for Administration Office:</span ></p >
        <p style="margin-left: 22px" >
            {{ $req['sep']["generalComments"] }}
        </p >
    @endif


@endsection