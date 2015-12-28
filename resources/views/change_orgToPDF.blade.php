@extends('exportTemplate')


@section('content')

    <p class="subHeader" >illy caffè North America, Inc.</p >
    <br >


    <span class="leftIdentation" >
<br ><p ></p >

        @if($req['fromAD'][0]['givenname'][0]!='')
            <div >The following changes has been made to the user
        <span class="setBold" >
            {{ $req['fromAD'][0]['givenname'][0] }} {{ $req['fromAD'][0]['sn'][0] }}

        </span >
            </div >

        @endif

        @if(count($req['changes'])>0)
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
            </ul >
        @endif
        @if($req['itComments']!='')
            <li >Additional Instructions: <span class="setBold" > {{ $req['itComments']  }} </span ></li >
        @endif

        <br ><p ></p >


@endsection