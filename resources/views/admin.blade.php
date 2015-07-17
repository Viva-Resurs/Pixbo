@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-0">
            <!--  side_nav -->
            <ul role="menu" class="nav nav-sidebar">
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $adminNav->roots()))
            </ul>

        </div>
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="content">
            @yield('admin_content')
            </div>
        </div>
    </div>
</div>
@stop