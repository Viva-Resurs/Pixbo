@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-8 col-md-offset-2 main">

            <!--  Flash messages -->
            <div id="alerts">
                @include ('flash::message')
            </div>

            @yield('content')
        </div>
    </div>
</div>
@stop