@extends('mainTemplate')


@section('javascript')
<script src="js/menu.js" ></script >
<script src="js/newHireThankYou.js" ></script >
@endsection

@section('css')
<link rel="stylesheet" href="css/navigation.css" >
@endsection

@section('content')

<br ><br ><p class="center" >Your request has been processed successfully<p >
<p >We have created two forms, one has been sent to Payroll and the other to service desk, these are the download
    links</p >
<p >Employee: {{ $name }} {{ $lastName }}

<ul class="ulNoStyle" >
    <li >Payroll form: <a target="_blank" href="" >kk</a ></li >
    <li >Service desk form: <a target="_blank" href="/report/{{ $newHireReport }}" >{{ $newHireReport }}</a ></li >
</ul >

<p >The reports are being stored in the <strong >"Human Resources"</strong > shared drive, under a folder named
    <strong >"Employee Action Forms"</strong >.</p >
<br ><br ><br ><p class="subHeader" >What's next: <br ></p >

<ul class="navigation" style="text-align: center" >
    <li class="myNavigation navigationLink" id="home" >Home Screen</a></li >
    <li class="myNavigation navigationLink" id="another" >Add another employee</li >
</ul >


@endsection

