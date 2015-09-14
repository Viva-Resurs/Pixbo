@extends('admin')


@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('title')
    ScreenGroup index
@stop


@section('content')

    <h1 class="page-header">{{ trans("messages.show_screen_group") }}</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info"> <!-- Info -->
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ 'Info' }}
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ trans('messages.id') }}</td>
                                <td>{{ $screenGroup->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('messages.name') }}</td>
                                <td>{{ $screenGroup->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('messages.desc') }}</td>
                                <td>{{ $screenGroup->desc  ? $screenGroup->desc : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('messages.rss_feed') }}</td>
                                <td>{{ $screenGroup->rss_feed ? $screenGroup->rss_feed : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('messages.created') }}</td>
                                <td>{{ $screenGroup->created_at }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('messages.updated') }}</td>
                                <td>{{ $screenGroup->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ trans('messages.event') }}
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>

                        @if(count($screenGroup->event))
                            @foreach($screenGroup->event as $event)
                                <tr>
                                    <td>{{ trans('messages.date') }}</td>
                                    <td>{{ $event->date }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('messages.start') }}</td>
                                    <td>{{ $event->start_time }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('messages.end') }}</td>
                                    <td>{{ $event->end_time }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('messages.recurring') }}</td>
                                    <td>{{ $event->recurring ? trans("messages.yes") : trans("messages.no") }}</td>
                                </tr>
                            @endforeach
                        @else
                            {{ trans('messages.schedule') }}
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-md-8 photo__gallery">
            <div class="panel panel-info"> <!-- Gallery -->
                <div class="panel-heading">
                    {{ trans('messages.screens') }}
                </div>
                <div class="panel-body">
                    @foreach ($screenGroup->screens->chunk(3) as $set)
                        <div class="row">
                            @foreach ($set as $element)

                                <div class="col-md-4 gallery__image">
                                    <a href="/admin/screens/{{ $element->id }}"</a>
                                        <img src="/{{ $element->photo->thumb_path }}" alt="">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop