@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3">
            <!--  side_nav -->
            <ul role="menu" class="nav nav-sidebar">
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $adminNav->roots()))
            </ul>

        </div>
        <div class="col-lg-9 col-md-9 col-sm-9">
            <div class="content">
            @yield('content')
            </div>
        </div>
    </div>
</div>
@stop