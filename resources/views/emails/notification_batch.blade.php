This is an automated email to inform you that there is a scheduled <strong >{{ $action }}</strong > due for today.<br >


The event is supposed to take place on <strong >{{ date(DATE_RFC2822) }}</strong >
for the user <strong >{{ $name }}</strong >.

@if($attachment)
    <br >
    <p >Reference document is attached.</p >
@endif

<br >
<p >HR User's action tool.</p >
<p >
    <italic >No reply to this email is necessary and no further action is required.</italic >
</p >