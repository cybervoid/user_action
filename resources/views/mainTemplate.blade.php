<!doctype html>
<html lang="en" >
<head >
    <meta charset="utf-8" >
    <title >Illy NA Roaming data activation</title >
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="css/main.css" >
    <link rel="stylesheet" href="vendor/jqueryui/themes/smoothness/theme.css" >
    <link rel="stylesheet" href="vendor/jqueryui/themes/smoothness/jquery-ui.min.css" >

    @yield('css')
    <script src="vendor/jquery/dist/jquery.js" ></script >
    @yield('headJavascript')


</head >
<body >

<div class="center mainFrm" >
    <img src="images/logo.bmp" >

    <h2 >USER NOTIFICATION ACTION TOOL</h2 >

    @if (isset($user->givenName))
    <div id="welcomeMsg" class="welcomeMsg" >Welcome {{ $user->givenName }}</div >
    @endif


    @yield('content')
</div >

<script src="vendor/jqueryui/jquery-ui.min.js" ></script >
<script src="vendor/handlebars/handlebars.js" ></script >
<script src="js/templates.js" ></script >
<script src="js/main.js" ></script >

@yield('javascript')

</body >
</html >
