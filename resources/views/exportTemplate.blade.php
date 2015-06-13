<!doctype html>
<html lang="en" >
<head >
    <meta charset="utf-8" >
    <title >Illy NA Roaming data activation</title >
    <style > span {
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


    <table border="0" width="50%" align="center" >
        <tr align="center" >
            <td align="left" >
                <span class="bold" >Printed name: Maren Gizicki</span ></td >
            <td align="right" ><span class="bold" >Date: {{ date('m-d-Y') }}<br ><br ><span >_____________________<br >Signature</span ></span >
            </td >
        </tr >
    </table >

</body >
</html >
