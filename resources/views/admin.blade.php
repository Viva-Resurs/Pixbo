@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Library</a></li>
            <li class="active">Data</li>
        </ol>
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