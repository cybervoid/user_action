@extends('exportTemplate')


@section('content')
    <?php

    //var_dump($changes['url']);
    //$email = $req['email'];
    //rafag {{ $req['changes'] }}
    //rafag {{ $req['changes']['givenname'] }}
    //rafag1 {{ $req['fromAD'][0]['sn'][0] }}
    ?>


    <p class="subHeader" >illy caffè North America, Inc.</p >
    <br >


    <span class="leftIdentation" >
<br ><p ></p >


        @if(count($req['changes'])>1)
            <div >The following changes has been made to the user
        <span class="setBold" >
            {{ $req['fromAD'][0]['givenname'][0] }} {{ $req['fromAD'][0]['sn'][0] }}

        </span >
            </div >
            <ul >
                @foreach(array_keys($req['changes']) as $key)

                    @if($req['changes'][$key] != $req['fromAD'][0][$key][0])
                        <li >Change from <span class="setBold" > {{ $req['fromAD'][0][$key][0]  }} </span > to <span
                                    class="setBold" > {{ $req['changes'][$key] }}</span >.
                        </li >
                    @endif


                @endforeach
            </ul >
        @endif

        <br ><p ></p >


@endsection