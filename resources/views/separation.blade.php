@extends('mainTemplate')

@section('javascript')
<script src="js/separation.js" ></script >
@endsection

@section('css')
<link rel="stylesheet" href="css/theForms.css" >
@endsection


@section('content')

<br>
<form method="post" id="frmUpdateInfo" name="frmUpdateInfo">
    <label>Search by Email</label>
    <input type="text" id="email" name="email" placeholder="name.lastname@illy.com" class="inputRender" value="rafael.gil@illy.com">
    <input type="button" value="Search" id="search" name="search" class="inputRender">

    <br>

    <br>
    <div class="report" id="report"></div>

    <input type="button" name="submit" id="submit" value="Submit" hidden="hidden" class="inputRender">

</form>
@endsection
