<!doctype html>
<html lang="en" >
<head >
    <meta charset="utf-8" >
    <title >Illy NA Roaming data activation</title >
    <link rel="stylesheet" href="{{ $server }}/css/export.css" >
</head >
<body >

<div class="centerObj" >
    <img src="{{ $server }}/images/logo.bmp" >

<p style="font-weight: bold" >USER NOTIFICATION FORM</p >

    <p >Human Resources<br >
        * Transactions to be processed within 48 hours of notification
    </p >

    <p class="subHeader" >illy caffè North America, Inc.</p >
</div>

    @yield('content')


<div class="signature">
    <table border="0" width="80%" align="center" >
        <tr align="center" >
            <td align="left" >
                <span class="remark" >Printed name:</span >
            <p ><span class="remark" >Date: </span >{{ date('m-d-Y') }}</p >
            </td >

            <td align="right" valign="bottom" ><span class="remark" >Maren Gizicki, HR Manager</span >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _____________________ Signature
            </td >
        </tr >
    </table >

</div>
</body >
</html >
