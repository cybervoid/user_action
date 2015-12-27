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
                <p ><span class="bold" >Name: </span > {{ $req['sep']["name"]}} {{$req['sep']["lastName"] }} </p >
            </td >
            <td ><p ><span class="bold" >Department/ Dept Code: </span > {{$req['sep']["department"]}} </p ></td >


            <td ><p ><span class="bold" >Employee ID #: </span >
                    {{$req['sep']["employeeID"]!='' ? $req['sep']["employeeID"]:'TBD' }}
                </p ></td >
        </tr >
    </table >


    <p ><span class="bold" >Title: </span > {{ $req['sep']["title"] }} </p >
    <p ><span class="bold" >Reports to: </span > {{ $req['sep']["manager"] }}</p >
    <span class="bold" >Termination/Separation</span ><br >
    <hr >
    <br >
    <table border="0" width="100%" >
        <tr align="center" valign="top" >
            <td align="left" ><span class="bold" >Termination Date: </span > {{$req['sep']["termDate"]}}
            </td >
            <td align="center" > {{ $req['sep']["effectiveDate"] }} - {{ $req['sep']["effectiveDate1"]}}<br ><span
                        class="bold" >Effective Date thru Date:</span >
            </td >
        </tr >

        @if(isset($req['sep']["onetime"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >One time Severance Pay: $</span > {{$req['sep']["onTimePayment"]}}
                </td >
            <tr >
        @endif

        @if(isset($req['sep']["severance"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >Continued Distribution of Severance Pay: $</span >
                    {{$req['sep']["severancePay"]}} Over # {{$req['sep']["overTime"]}} Months/Weeks
                </td >
            <tr >
        @endif

        @if(isset($req['sep']["cobra"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >COBRA Period paid: </span > {{$req['sep']["periodPaid"]}}
                </td >
            <tr >
        @endif


        @if(isset($req['sep']["ptoDays"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >P.TO days/Hours: </span >{{$req['sep']["ptoDays"] }}
                </td >
            <tr >
        @endif

        @if(isset($req['sep']["otherComments"]))
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >Other (Explain Below):</span >
                </td >
            <tr >
        @endif

        @if($req['sep']["commentsPayroll"] != '')
            <tr colspan="2" >
                <td >
                    <br ><span class="bold" >Comments/Notes for Payroll:</span > {{$req['sep']["commentsPayroll"]}}
                </td >
            <tr >
        @endif

    </table >
    <br ><p ></p ><br >

@endsection


