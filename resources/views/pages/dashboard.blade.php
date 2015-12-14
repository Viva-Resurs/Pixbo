@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-8 col-md-offset-2 main">
            <!--  Flash messages -->
            @include ('flash::message')

            <div class="content">

                <div class="row">
                    @include('screengroups.screengroup__card')
                </div>

                @can('view_dashboard')

                @endcan
            </div>
        </div>
    </div>
</div>
@stop
