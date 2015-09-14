@extends('admin')

@section('title')
Screen index
@stop


@section('content')

<h1 class="page-header">{{ trans("messages.show_screen") }}</h1>

<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">
                    {{ trans('messages.info') }}
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ trans('messages.id') }}</td>
                            <td>{{ $screen->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.name') }}</td>
                            <td>{{ $screen->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.event') }}</td>
                            <td>TODO</td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.screen_groups') }}</td>
                            <td>
                            @foreach ($screen->screengroups as $index => $screengroup)
                                @if($index != count($screen->screengroups) -1)
                                    {{ $screengroup->name }},
                                @else
                                    {{ $screengroup->name }}
                                @endif
                            @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.created') }}</td>
                            <td>{{ $screen->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.updated') }}</td>
                            <td>{{ $screen->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
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
</div>

@stop
