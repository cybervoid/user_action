Hi {{ $name }},

<br>
<p>You are receiving this email because changes has been made to your account and they should reflect on your Outlook signature.
</p>


<ul >
    @foreach(array_keys($changes) as $key)
        <li >Change from <span class="setBold" > {{ $currentInfo[$key]  }} </span > to <span
                    class="setBold" > {{ $changes[$key] }}</span >.
        </li >
    @endforeach
</ul >

<p>
You can update your own signature or follow this link while you are on VPN and the signature will be updated automatically.</p>
<p>
"\\illy-nas\it\scripts\signature\illy_signature.vbs"
</p>

<br>
<p>If you are having any issue with this procedure please let us know.</p>
<p>
    IT Department<br>
    illy caffè North America, Inc</p>
