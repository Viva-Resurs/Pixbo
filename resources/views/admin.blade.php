@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="main">

            <!--  Flash messages -->
            <div id="alerts">
                @include ('flash::message')
                <toast></toast>
            </div>
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@stop