@extends('mainTemplate')

<link rel="stylesheet" href="css/mainPage.css">
@section('content')


<img src="images/logo.bmp">


<h1>
    USER NOTIFICATION FORM</h1>


<div id="welcomeMsg" class="welcomeMsg">Welcome {{ $user->givenName }}</div>


<br>
<ul class="navigation">
    <li class="myNavigation navigationLink" id="newHire">New Hire</a></li>
    <li class="myNavigation navigationLink" id="termination">Separation</li>
    <li class="myNavigation navigationLink" id="org_change">Organization Change</li>
</ul>


<br>

<script src="js/menu.js"></script>
<script src="js/dashboard.js"></script>

@endsection
