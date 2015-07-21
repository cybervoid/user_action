@extends('mainTemplate')


@section('javascript')
<script src="js/menu.js" ></script >
<script src="js/thankYou.js" ></script >
@endsection

@section('css')
<link rel="stylesheet" href="css/navigation.css" >
@endsection

@section('content')


<br ><br ><p class="center" >Your request has been processed successfully<p >


    @if($reportType=='separation')
<p >The form was created successfully and has been sent to service desk, below is the download link</p >

@else
<p >We have created two forms, one has been sent to Payroll and the other to service desk, these are the download
    links</p >
@endif

<p >Employee: <strong >{{ $name }} {{ $lastName }} </strong >


<ul class="ulNoStyle" >
    @if(isset($newHireReport))
    <li >Service Desk Form: <a target="_blank" href="{{ $newHireRouteURL }}{{ $newHireReport }}" >{{ $newHireReport
            }}</a >
    </li >
    @endif
    @if(isset($payrollReport))
    <li >Payroll Form: <a target="_blank" href="{{ $payrollRouteURL }}{{ $payrollReport }}" >{{ $payrollReport }}</a >
    </li >
    @endif
    @if(isset($separationReport))
            <li >Separation Form: <a target="_blank" href="{{ $separationRouteURL }}{{ $separationReport }}" >{{ $separationReport
            }}</a >
    </li >
    @endif

</ul >

<p >The reports are being stored in the <strong >"Human Resources"</strong > shared drive, under a folder named
    <strong >"Employee Action Forms"</strong >.</p >


<p >

    @if ($sendMail)
    The following users has been notified with this form: <br >
<div style="width: 50%; margin: 0 auto;" >
    <ul style="text-align: left" >
        @foreach ($sendMail as $recipient)
        <li ><a target="_blank" href="mailto:{{ $recipient }}" >{{ $recipient }}</a ></li >
        @endforeach
    </ul >
    <p class="notify" >Total notifications sent <strong >{{ count($sendMail) }}</strong ></p >
</div >
@endif


</p>


<br ><br ><br ><p class="subHeader" >What's next: <br ></p >

<ul class="navigation" style="text-align: center" >
    <li class="myNavigation navigationLink" id="home" >Home Screen</li >

    @if($reportType=='separation')
    <li class="myNavigation navigationLink" id="separation" >Enter another separation</li >
    @else
    <li class="myNavigation navigationLink" id="newHire" >Add another employee</li >
    @endif

</ul >


@endsection

