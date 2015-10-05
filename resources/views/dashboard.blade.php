@extends('mainTemplate')


@section('javascript')
<script src="js/menu.js" ></script >

@endsection

@section('css')
<link rel="stylesheet" href="css/navigation.css" >
@endsection


@section('content')

<br >
<ul class="navigation" >
    <li class="myNavigation navigationLink" id="newHire" >New Hire</li >
    <li class="myNavigation navigationLink" id="separation" >Separation</li >
    <li class="myNavigation navigationLink" id="org_change" >Organization Change</li >
</ul >

<br >

@endsection
