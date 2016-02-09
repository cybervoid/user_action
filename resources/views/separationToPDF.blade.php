@extends('exportTemplate')
@section('content')


    <div class="centerObj remark page_title" ><p >Separation</p ></div >

    <div class="container custom_top" >
        <div class="row" ><span class="remark">Name:</span> {{ $req['sep']['name'] }} {{ $req['sep']['lastName'] }}</div >
        <div class="row" ><span class="remark">Employee ID:</span> {{ $req['sep']['employeeID']!='' ? $req['sep']['employeeID']:'TBD' }}</div >
        @if ($req['sep']["buddy"]!='')
        <div class="row" ><span class="remark">Buddy:</span> {{ $req['sep']['buddy'] }}</div >
            @endif
    </div >

    <div class="container custom_top" >
        <div class="row" ><span class="remark">Company:</span>{{ $req['sep']['company'] }}</div >
        <div class="row" ><span class="remark">Department:</span> {{ $req['sep']['department'] }}</div >
        <div class="row" ><span class="remark">Manager:</span> {{ $req['sep']['manager'] }}</div >
    </div >

    @if (isset($req['sep']["title"]))
        <div class="custom_top" >
        <p ><span class="remark">Title: </span > {{ $req['sep']["title"] }}</p >
        </div>
    @endif

    <div class="container custom_top" >
        <div class="row" ><span class="remark">Separation Date:</span> {{ $req['sep']['termDate'] }}</div >
        <div class="row" ><span class="remark">Hire Status:</span> {{ $req['sep']['hireStatus'] }}</div >
        @if (isset($req['sep']["location_Other"]))
        <div class="row" ><span class="remark">Location:</span> {{ $req['sep']["location"] }} {{ $req['sep']["location_Other"] }}</div >
        @endif
    </div >


    @if (isset($req['sep']["iTDeptEmail"]))

        <p ><span class="remark">IT Department Checklist: Rafael Gil and Service Desk</span ></p >

        <p ><span class="remark">E-Mail Distribution List:</span ></p >
        <ul >


            @foreach($req['sep']["iTDeptEmail"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif


    @if (isset($req['sep']["iTDept"]))
        <p ><span class="remark">Assets:</span ></p >
        <ul >
            @foreach($req['sep']["iTDept"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif


    @if ($req['sep']["itComments"]!='')
        <p ><span class="remark">Additional instructions for IT:</span ></p >
        <p style="margin-left: 22px" >
            {{ $req['sep']["itComments"] }}
        </p >
    @endif


    @if(isset($req['sep']["oracle"]))
        <p ><span class="remark">Oracle Specialist Natasha D'Souza</span ></p >
        <ul >
            <li >Oracle Access/Oracle (HR) Number Approval (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)
            </li >
        </ul >
    @endif

    @if(isset($req['sep']["oManager"]))
        <p ><span class="remark">HQ Office Manager-Suzie Schwab</span ></p >

        <ul >
            @foreach($req['sep']["oManager"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif


    @if(isset($req['sep']["creditCard"]))
        <p ><span class="remark">Finance- (Credit Card and Concur Access Requests) *new hires and separation</span >
        </p >
        <ul >
            @foreach($req['sep']["creditCard"] as $item)
                <li >{{ $item }}</li >
            @endforeach
        </ul >
    @endif

    @if ($req['sep']["generalComments"]!='')
        <p ><span class="remark">Additional instructions for Administration Office:</span ></p >
        <p style="margin-left: 22px" >
            {{ $req['sep']["generalComments"] }}
        </p >
    @endif


@endsection