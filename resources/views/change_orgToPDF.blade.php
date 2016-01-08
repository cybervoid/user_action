@extends('exportTemplate')
@section('content')

    <div class="centerObj remark page_title" ><p >Organization Change </p ></div >

    <div class="container custom_top" >
        <div class="row" ><span class="remark">Name:</span> {{ $req['main_req']['name'] }} {{ $req['main_req']['lastName'] }}</div >
        <div class="row" ><span class="remark">Employee ID:</span> {{ $req['main_req']['employeeID']!='' ? $req['main_req']['employeeID']:'TBD' }}</div >
        <div class="row" ><span class="remark">Email:</span> <a href="mailto:{{ $req['main_req']['newEmail'] }}" >{{ $req['main_req']['newEmail'] }}</a ></div >
    </div >

    <div class="custom_top" >
        <span class="remark">Title:</span> {{ $req['main_req']['title'] }}
    </div >

    <div class="container custom_top" >
        <div class="row" ><span class="remark">Company:</span> {{ $req['main_req']['company'] }}</div >
        <div class="row" ><span class="remark">Department:</span> {{ $req['main_req']['department'] }}</div >
        <div class="row" ><span class="remark">Manager:</span> {{ $req['main_req']['manager'] }}</div >
    </div >

    <div class="container custom_top" >
        <div class="row" ><span class="remark">Effective Date:</span> {{ $req['main_req']['effectiveDate'] }}</div >
        @if($req['main_req']['hireStatus']!='')
            <div class="row" ><span class="remark">Hire Status</span> {{ $req['main_req']['hireStatus'] }}</div >
            @endif
    </div >

        @if(count($req['changes'])>0)
            <div class="custom_top">
                <span class="remark">Detected Changes:</span>
            </div>

            <ul >
                @foreach(array_keys($req['changes']) as $key)
                    @if($req['changes'][$key] != $req['fromAD'][0][$key][0] && $key!='manager')
                        <li >Change from <span class="setBold" > {{ $req['fromAD'][0][$key][0]  }} </span > to <span
                                    class="setBold" > {{ $req['changes'][$key] }}</span >.
                        </li >
                    @endif
                @endforeach
                @if(isset($req['changes']['manager']))
                    <li >Manager change from <span class="setBold" > {{ $req['oldManagerName']  }} </span > to <span
                                class="setBold" > {{ $req['newManagerName'] }} </span > made.
                    </li >
                @endif

        @endif
        @if($req['itComments']!='')
            <li >Additional Instructions: <span class="setBold" > {{ $req['itComments']  }} </span ></li >
        @endif
            </ul >
        <br ><p ></p >


@endsection