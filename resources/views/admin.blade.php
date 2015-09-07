@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <!--  side_nav -->
            <ul role="menu" class="nav nav-sidebar">
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $adminNav->roots()))
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <!--  Flash messages -->
            <div id="alerts">
                @include ('flash::message')
            </div>

            @yield('content')
        </div>
    </div>
</div>
@stop