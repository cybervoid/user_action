@extends('exportTemplate')

@section('content')

    <style type="text/css" >
        #watermark {

            color: #d0d0d0;
            font-size: 50pt;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            position: absolute;
            width: 50%;
            height: 50%;
            margin: 0;
            z-index: -1;
            left: 100px;
            top: 100px;
        }
    </style >

    <div id="watermarks" >
        <p >illy caffè North America, Inc.</p >

    </div >
    {{--<div>--}}
    {{--<img src="images/illy-watermark.png">--}}
    {{--</div>--}}




    <p class="bold" >Payroll Separation form</p ></div>


    <table border="0" width="100%" >
        <tr align="center" >
            <td >
                <p ><span class="bold" >Name: </span > {{ $req["name"]}} {{$req["lastName"] }} </p >
            </td >
            <td ><p ><span class="bold" >Department/ Dept Code: </span > {{$req["department"]}} </p ></td >


            <td ><p ><span class="bold" >Employee ID #: </span >
                    {{$req["employeeID"]!='' ? $req["employeeID"]:'TBD' }}
                </p ></td >
        </tr >
    </table >


    <p ><span class="bold" >Title: </span > {{ $req["title"] }} </p >
    <p ><span class="bold" >Reports to: </span > {{ $req["manager"] }}</p >
    <span class="bold" >Termination/Separation</span ><br >
    <hr >
    <br >
    <table border="0" width="100%" >
        <tr align="center" valign="top" >
            <td align="left" ><span class="bold" >Termination Date: </span > {{$req["termDate"]}}
            </td >
            <td align="center" > {{ $req["effectiveDate"] }} - {{ $req["effectiveDate1"]}}<br ><span class="bold" >Effective Date thru Date:</span >
            </td >
        </tr >

        @if(isset($req["onetime"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >One time Severance Pay: $</span > {{$req["onTimePayment"]}}
                </td >
            <tr >
        @endif

        @if(isset($req["severance"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >Continued Distribution of Severance Pay: $</span >
                    {{$req["severancePay"]}} Over # {{$req["overTime"]}} Months/Weeks
                </td >
            <tr >
        @endif

        @if(isset($req["cobra"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >COBRA Period paid: </span > {{$req["periodPaid"]}}
                </td >
            <tr >
        @endif


        @if(isset($req["ptoDays"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >P.TO days/Hours: </span >{{$req["ptoDays"] }}
                </td >
            <tr >
        @endif

        @if(isset($req["otherComments"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >Other (Explain Below):</span >
                </td >
            <tr >
        @endif

        @if($req["commentsPayroll"] != '')
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >Comments/Notes for Payroll:</span > {{$req["commentsPayroll"]}}
                </td >
            <tr >
        @endif

    </table >
    <br ><p ></p ><br >

@endsection


