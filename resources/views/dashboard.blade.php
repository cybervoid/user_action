@extends('mainTemplate')
@include('menuTemplate')


@section('javascript')
<script src="js/menu.js" ></script >

@endsection

@section('css')
<link rel="stylesheet" href="css/navigation.css" >
@endsection


@section('content')

<br >
@yield('menu')


<br >

@endsection
