@section('menu')
    <ul class="navigation" >
        @if(isset($menu_Home))
            <li class="myNavigation navigationLink" id="home" >Home</li >
        @endif
        @if(isset($menu_New))
            <li class="myNavigation navigationLink" id="newHire" >New Hire</li >
        @endif
        @if(isset($menu_Separation))
            <li class="myNavigation navigationLink" id="separation" >Separation</li >
        @endif
        @if(isset($menu_Org_Change))
            <li class="myNavigation navigationLink" id="org_change" >Organization Change</li >
        @endif
    </ul >
@endsection