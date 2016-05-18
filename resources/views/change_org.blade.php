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

<p class="subHeader">Change Organization Section</p>
<br>
<form method="post" action="/change_org_verify" name="org_change" id="org_change" >
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >
    <label >Search user</label >
    <input type="text" id="user" name="user"class="inputRender" autocomplete="off"> <span
        id="searchProgress" ></span >
    <p >
    <div id="manual-add" class="element-as-link" >Manually Add user</div >

    </p>
    <br ><br >

    <div class="report" id="report" >

        <div ></div >
        <br >

        <p ></p >
        <ul class="navigation" style="text-align: center" >
            <li class="myNavigation navigationLink" id="home" >Home Screen</li >
        </ul >


    </div >


</form >
@endsection
