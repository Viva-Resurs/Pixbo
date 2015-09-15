@extends('admin')

@section('content')

    <h1 class="page-header">{{ trans('messages.edit_screen') }}</h1>

    <div class="col-md-6">
        <div class="panel panel-info">
              <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('messages.info') }}</h3>
              </div>
              <div class="panel-body">
                    {!! Form::model($screen, ['method' => 'PATCH', 'route' => ['admin.screens.update', $screen->id]]) !!}
                            @include ('screens.__form', ['submitButtonText' => trans('messages.save')])
                    {!! Form::close() !!}
              </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="panel panel-info">
              <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('messages.image') }}</h3>
              </div>
              <div class="panel-body">
                    <img src="/{{ $screen->photo->thumb_path }}">
              </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">
                    {{ 'Event' }}
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    {!! Form::model($event, ['method' => 'PATCH', 'route' => ['admin.events.update', $event->id]]) !!}
                        @include ('events.__form', ['submitButtonText' => trans('messages.save')])
                        <a class="btn btn-primary" data-toggle="modal" href='#event_meta'>Trigger modal</a>
                    {!! Form::close() !!}
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('events.meta.__form')
@stop
