This email is to inform you that there was a schedueled separation and is due today.


The event is supposed to take place on <strong >{{ date(DATE_RFC2822) }}</strong >
for the user <strong >{{ $name }}</strong >  and the request is a <strong >{{ $action }}</strong >.

@if($attachment)
    <br >Reference document is attached.
@endif
