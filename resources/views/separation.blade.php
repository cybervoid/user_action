@extends('mainTemplate')

@section('content')

<link rel="stylesheet" href="css/theForms.css">


@if (isset($req))

<h2>{{ $req->userName }}</h2>
@endif

Separation


<form method="post" action="/" name="newHire" id="newHire">
    <label>Username</label>
    <input type="input" name="userName" id="userName" class="inputRender" required=""><br>
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <label>Password</label>
    <input type="password" name="password" id="password" class="inputRender" required=""><br>
    <input type="submit" value="Login" class="inputRender"><br>

</form>

<div id="report"></div>
<script src="js/separation.js"></script>
@endsection
