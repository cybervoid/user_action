@extends('mainTemplate')
@include('menuTemplate')

@section('javascript')
    <script src="js/menu.js" ></script >
    <script src="js/groupsAD.js" ></script >
    <script src="js/change_org.js" ></script >

@endsection

@section('css')
    <link rel="stylesheet" href="css/navigation.css" >
    <link rel="stylesheet" href="css/theForms.css" >

@endsection


@section('content')


    @if(count($changes)<0)

        No changes were detected, please see options below.<br >
        <br ><p ></p >
        <br ><p ></p >
        <br ><p ></p >
        <br ><p ></p >
        @yield('menu')
    @else


        <p class="subHeader" >Please verify your information before proceeding...</p >
        <br >
        <form method="post" action="/change_org_save" name="org_change_save" id="org_change_save" >
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >

<span class="leftIdentation" >
<br ><p ></p >


    @if(count($changes)>0)
        <div >We have detected the following changes:</div >
        <ul class="listNoBullets" >
            @foreach(array_keys($changes) as $key)


                @if($changes[$key] != $fromAD[0][$key][0] && $key!='manager')
                    <li >Change from <span class="noticeThis" > {{ $fromAD[0][$key][0]  }} </span > to <span
                                class="noticeThis" > {{ $changes[$key] }} </span > detected.
                    </li >
                @endif

            @endforeach

            @if(isset($changes['manager']))
                <li >Manager change from <span class="noticeThis" > {{ $manager['oldManager']  }} </span > to <span
                            class="noticeThis" > {{ $manager['name'] }} </span > detected.
                </li >
            @endif
        </ul >
    @else
        <p class="centerMe" >
        <h3 class="centerMe" >No changes were detected</h3 ></p>
        @if($req['itComments']!='')
            But we noticed you filled out the "Instructions" field, if you click on submit no changes are going to be
            made to this user's information, but a notification form will be sent out with the written additional
            instructions
            field content so the appropriate users can be notified.<br >
            If this is not what you intended to do please go back and start over.
        @endif
    @endif

    <br ><p ></p >

<div >Below is the updated information being stored in our system for this user</div >


<ul >
    <li >Name: <span class="noticeThis" > {{ $req['name']  }} </span ></li >
    <li >Last Name: <span class="noticeThis" > {{ $req['lastName']  }} </span ></li >
    <li >Email: <span class="noticeThis" > {{ $req['newEmail']  }} </span ></li >
    <li >employee ID: <span class="noticeThis" > {{ ($req['employeeID']!='')? $req['employeeID']:'TBD'  }} </span >
    </li >
    <li >Title: <span class="noticeThis" > {{ $req['title']  }} </span ></li >
    <li >Department: <span class="noticeThis" > {{ $req['department']  }} </span ></li >
    <li >Company: <span class="noticeThis" > {{ $req['company']  }} </span ></li >
    <li >Manager: <span class="noticeThis" > {{ $req['manager']  }} </span ></li >
    @if($req['itComments']!='')
        <li >Comments: <span class="noticeThis" > {{ $req['itComments']  }} </span ></li >
        <input type="hidden" name="itComments" value="{{ $req['itComments']  }}" >
    @endif
</ul >

<input type="button" class="inputRender" name="cancel" id="cancel" value="Cancel"
       onclick="document.location.href='change_org'" >
    @if(count($changes)>0 || $req['itComments']!='')
        <input type="submit" class="inputRender" name="submit" id="submit" >
    @endif

    <input type="hidden" name="reportType" id="reportType" value="change_org" >
<input type="hidden" name="email" id="email" value="{{ $fromAD[0]['mail'][0]  }}" >
<input type="hidden" name="params" id="params" value="<?php echo base64_encode(json_encode($changes)); ?>" >

</span >

        </form >
    @endif


@endsection
