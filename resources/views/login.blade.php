@extends('mainTemplate')

@section('content')

<script>
    $(document).ready(function(){
        $("#userName").focus();
    });
</script>



<p style="color: red;
                    @if (!Session::get('message'))
                            display: none
                    @endif">
    {{ Session::get('message') }}
</p>


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
