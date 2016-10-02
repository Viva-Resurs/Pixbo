@extends('admin')

@section('title')
{{ trans("messages.show_screen") }}
@stop


@section('content')

<h1 class="page-header">{{ trans("messages.show_screen") }}</h1>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="/{{ $screen->photo->path }}" style="max-height: 100%; max-width: 100%">
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
              <div class="panel-body">
                    <schedule id="{{ $screen->id }}" model="screens"></schedule>
                    @include('shared.schedule.template', ['item' => $screen, 'model' => 'screens'])

              </div>
              <div class="panel-footer">
                  @include('shared.schedule.submit_button', ['item' => $screen, 'class' => 'pull-right'])
              </div>
        </div>
    </div>
</div>
@stop