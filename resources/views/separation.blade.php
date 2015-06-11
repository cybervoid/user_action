@extends('mainTemplate')

@section('javascript')
<script src="js/separation.js" ></script >
@endsection

@section('css')
<link rel="stylesheet" href="css/theForms.css" >
@endsection


@section('content')

<br >
<form method="post" action="/separation_add" name="separation" id="separation" >
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >
    <label >Search by Email</label >
    <input type="text" id="email" name="email" placeholder="name.lastname@illy.com" class="inputRender"
           value="donald.duck@illy.com" >
    <input type="button" value="Search" id="search" name="search" class="inputRender" >

    <br >

    <br >

    <div class="report" id="report" ></div >


</form >
@endsection
