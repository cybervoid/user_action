@extends('mainTemplate')

@section('javascript')
    <script src="js/menu.js" ></script >
    <script src="js/groupsAD.js" ></script >
    <script src="js/change_org.js" ></script >

@endsection

@section('css')
    <link rel="stylesheet" href="css/navigation.css" >
    <link rel="stylesheet" href="css/theForms.css" >

@endsection


@section('content')


    @if(count($changes)<1)

        No changes were detected, please see options below.
    @else


        <p class="subHeader" >Please verify your information before proceeding...</p >
        <br >
        <form method="post" action="/change_org_save" name="org_change_save" id="org_change_save" >
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >

<span class="leftIdentation" >
<br ><p ></p >

    @if(count($changes)>1)
        <div >We have detected the following changes:</div >
        <ul >
            @foreach(array_keys($changes) as $key)
                @if($changes[$key] != $fromAD[$key])
                    <li >Change from <span class="noticeThis" > {{ $fromAD[$key]  }} </span > to <span
                                class="noticeThis" > {{ $changes[$key] }} </span > detected.
                    </li >
                @endif
            @endforeach
        </ul >
    @endif

    <br ><p ></p >

<div >Below is the updated information being stored in our system for this user</div >


<ul >
    <li >Name: <span class="noticeThis" > {{ $req['name']  }} </span ></li >
    <li >Last Name: <span class="noticeThis" > {{ $req['lastName']  }} </span ></li >
    <li >Email: <span class="noticeThis" > {{ $req['newEmail']  }} </span ></li >
    <li >employee ID: <span class="noticeThis" > {{ ($req['employeeID']!='')? $req['employeeID']:'TBD'  }} </span >
    </li >
    <li >Title: <span class="noticeThis" > {{ $req['title']  }} </span ></li >
    <li >Department: <span class="noticeThis" > {{ $req['department']  }} </span ></li >
    <li >Company: <span class="noticeThis" > {{ $req['company']  }} </span ></li >
    <li >Manager: <span class="noticeThis" > {{ $req['manager']  }} </span ></li >
</ul >

<input type="button" class="inputRender" name="cancel" id="cancel" value="Cancel" >
<input type="submit" class="inputRender" name="submit" id="submit" >

<input type="hidden" name="params" id="params" value="<?php echo base64_encode(json_encode($req)); ?>" >

</span >

        </form >
    @endif

    <div id="homeMenu" >
        <br ><br ><br >

        <p class="subHeader" >Other options: <br ></p >
        <ul class="navigation" style="text-align: center" >
            <li class="myNavigation navigationLink" id="home" >Home Screen</a></li >
        </ul >
    </div >


@endsection
