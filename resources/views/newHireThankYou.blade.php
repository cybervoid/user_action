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
<p >Employee: <strong>{{ $name }} {{ $lastName }} </strong>

<ul class="ulNoStyle" >

    <li >Service desk form: <a target="_blank" href="/report/{{ $newHireReport }}" >{{ $newHireReport }}</a ></li >
</ul >

<p >The reports are being stored in the <strong >"Human Resources"</strong > shared drive, under a folder named
    <strong >"Employee Action Forms"</strong >.</p >



<p >

    @if ($sendMail)
    The following users has been notified with this form: <br >
<div style="width: 50%; margin: 0 auto;">
    <ul style="text-align: left">
        @foreach ($sendMail as $recipient)
        <li> <a target="_blank" href="mailto:{{ $recipient }}">{{ $recipient }}</a> </li>
        @endforeach
    </ul>
    <p class="notify">Total notifications sent <strong>{{ count($sendMail) }}</strong></p>
</div>
@endif


</p>


<br ><br ><br ><p class="subHeader" >What's next: <br ></p >

<ul class="navigation" style="text-align: center" >
    <li class="myNavigation navigationLink" id="home" >Home Screen</a></li >
    <li class="myNavigation navigationLink" id="another" >Add another employee</li >
</ul >


@endsection

