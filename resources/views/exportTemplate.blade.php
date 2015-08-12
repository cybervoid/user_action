<!doctype html>
<html lang="en" >
<head >
    <meta charset="utf-8" >
    <title >Illy NA Roaming data activation</title >
    <style >

        /*
                body {
                    background: url({{ $server }}/images/illy-watermark.png) repeat-y fixed 50% 50%;
        }
*/
        span {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .alignLeft {
            float: left;
            width: 50%;
        }

        li:before {
            content: '✔';
            margin-left: -1em;
            margin-right: .100em;
        }

        ul {
            padding-left: 20px;
            text-indent: 2px;
            list-style: none;
            list-style-position: outside;
        }


    </style >
</head >
<body >

<div class="center" >
    <img src="{{ $server }}/images/logo.bmp" >
</div >

<div class="center" ><p style="font-weight: bold" >USER NOTIFICATION FORM</p >

    <p >Human Resources<br >
        * Transactions to be processed within 48 hours of notification
    </p >

    @yield('content')


    <table border="0" width="80%" align="center" >
        <tr align="center" >
            <td align="left" >
                <span class="bold" >Printed name:
            <p >Date: {{ date('m-d-Y') }}</p ></span >
            </td >

            <td align="right" valign="bottom" ><span class="bold" >Maren Gizicki, HR Manager
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _____________________ Signature</span >
            </td >
        </tr >
    </table >

</body >
</html >
