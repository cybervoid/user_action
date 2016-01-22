This is an automated email to inform you that a scheduled <strong >{{ $action }}</strong > has been processed
for the user <strong >{{ $name }}</strong >.<br>


The event was supposed to take place on <strong >{{ date(DATE_RFC2822) }}</strong >


@if($attachment)
    <br >
    <p >Reference document is attached.</p >
@endif

<br >
<p >HR User's action tool.</p >
<p >
    <italic >No reply to this email is necessary and no further action is required.</italic >
</p >