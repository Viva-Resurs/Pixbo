@extends('app')

@section ('header')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@stop

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
            @include ('flash::message')

            <div class="content">

            <div class="page-header">
              <h1>Events Calendar</h1>
            </div>
                <div class="row">
                    <div class="col-md-8">
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-info">
                              <div class="panel-heading">
                                    <h3 class="panel-title">Events</h3>
                              </div>
                              <div class="panel-body">
                                    Panel content
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
