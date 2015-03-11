@extends('mainTemplate')

@section('content')

<script>
    $(document).ready(function(){
        $("#userName").focus();
    });
</script>

<img src="images/logo.bmp">


<h1>
    illy Human Resources User Notification Tool</h1>

Please enter your company's credentials above<br><br>
<div class="processForm">
    <form method="post" action="/login" name="loginFrm" id="loginFrm">
        <label>Username</label>
        <input type="input" name="userName" id="userName" class="inputRender" required=""><br>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <label>Password</label>
        <input type="password" name="password" id="password" class="inputRender" required=""><br>
        <input type="submit" value="Login" class="inputRender"><br>

    </form>
</div>


@endsection
