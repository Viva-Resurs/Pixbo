@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 main">

            <!--  Flash messages -->
            <div id="alerts">
                @include ('flash::message')
                <toast></toast>
            </div>

            @yield('content')
            
        </div>
    </div>
</div>
@stop