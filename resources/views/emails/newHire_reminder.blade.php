<p >This is an automated email to remind you there is a new hire starting on
    <font color="red" ><strong >{{ $date  }}</strong ></font >.</p >

<p >New hire name: <strong >{{ $name }}</strong ></p >

<br >

<p ><strong >Check list for IT</strong ></p >
<ul >
    <li >Change the default password</li >
    <li >Check if the groups are applied properly</li >
    <li >Username: {{ $samaccountname }}</li >
</ul >
<br >


{{ $attachment }}
@if( !empty($attachment))
    <p ><strong >Check list for Human Resources</strong ></p >
<ul >
    <li >Prepare the user in JDE</li >
</ul >
@endif



<p >
    Start date: <font color="red" ><strong >{{ $date  }}</strong ></font >
</p >