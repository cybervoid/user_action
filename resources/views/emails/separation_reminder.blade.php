Greetings,


This is an automated email from the Human Resources Department to remind you that today is 6 month since
the user <strong >{{ $name }}</strong > was separated from the company, you might consider to
delete it from AD and exchange.
<p >
<ul >
    <li >Name: <strong >{{ $name }}</strong ></li >
    <li >User: <strong >{{ $samaccountname }}</strong ></li >
    <li >Effective Separation date: <strong >{{ $separationDate }}</strong ></li >
</ul >
</p>

<br >
@if($comment)
    We found some comments in the separation form sent by HR, it might help with
    the steps to follow with this user:<br >

    <i ><p >
            ... "{{ $comment }} "...

        </p ></i >
@endif


@if($attachment)
    <br ><br ><p >Reference document is attached.</p >
@endif


<br >
<strong >
    <p >
        Rafael Gil
    </p >
</strong >