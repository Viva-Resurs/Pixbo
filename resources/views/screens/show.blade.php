@extends('admin')

@section('title')
{{ trans("messages.show_screen") }}
@stop


@section('content')

<h1 class="page-header">{{ trans("messages.show_screen") }}</h1>

<div class="row">
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="/{{ $screen->photo->path }}" style="max-height: 100%; max-width: 100%">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-default">
              <div class="panel-body">
                    Tags
                    Område
                    Schemalägg
                    {!! Form::model($event, ['method' => 'PATCH', 'route' => ['admin.events.update', $event->id]], ['class' => 'form-horizontal', 'id' => 'event_meta_form']) !!}
            {{ csrf_field() }}
                <div class="modal-body row">
                    <div class="col-md-4">
                        {{ trans('messages.repeat') }}
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::select('recur_type', array(
                                'daily' => trans("messages.daily"),
                                'weekly' => trans('messages.weekly'),
                                'monthly' => trans('messages.monthly'),
                                'yearly' => trans('messages.yearly')
                            ), null)
                            !!}

                        </div>
                    </div>

                    <div class="recurrence-settings">
                        @include('events.meta.daily__form')
                        @include('events.meta.weekly__form')
                        @include('events.meta.monthly__form')
                        @include('events.meta.yearly__form')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>
                    {!! Form::submit(trans('messages.save'), ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
              </div>
        </div>
    </div>
</div>


@stop
