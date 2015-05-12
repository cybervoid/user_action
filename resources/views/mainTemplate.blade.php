<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Illy NA Roaming data activation</title>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="jquery/smoothness/jquery-ui-1.10.4.custom.css">
        <script src="vendor/jquery/dist/jquery.js"></script>



    </head>
    <body>

    <div class="center mainFrm">
        <img src="images/logo.bmp">
        <h2>USER NOTIFICATION ACTION TOOL</h2>

        @if (isset($user->givenName))
            <div id="welcomeMsg" class="welcomeMsg">Welcome {{ $user->givenName }}</div>
        @endif



        @yield('content')
    </div>


    <script src="js/jquery-ui.js"></script>

    <script src="vendor/handlebars/handlebars.js"></script>
    <script src="js/templates.js"></script>
    </body>
</html>
