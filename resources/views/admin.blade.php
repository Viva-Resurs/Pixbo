@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 main">

            <!--  Flash messages -->
            <div id="alerts">
                @include ('flash::message')
                <toast></toast>
            </div>
            
            <div class="panel">
                @yield('content')
            </div>

        </div>
    </div>
</div>
@stop