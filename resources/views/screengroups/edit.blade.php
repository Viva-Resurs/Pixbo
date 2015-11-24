@extends('admin')


@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('title')
    ScreenGroup index
@stop


@section('content')

    <h1 class="page-header">{{ "ScreenGroup Edit" }}</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info"> <!-- Info -->
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ trans('messages.info') }}
                    </div>
                </div>
                <div class="panel-body">
                        {!! Form::model($screenGroup, ['method' => 'PATCH', 'route' => ['admin.screengroups.update', $screenGroup->id]]) !!}
                            @include ('screengroups.__form', ['submitButtonText' => trans('messages.save')])
                        {!! Form::close() !!}
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

                                {!! Form::model($event, ['method' => 'PATCH', 'route' => ['admin.events.update', $event->id]]) !!}
                                    @include ('events.__form', ['submitButtonText' => trans('messages.save')])
                                    <a class="btn btn-primary" data-toggle="modal" href='#event_meta'>{{ trans('messages.recurring') }}</a>
                                {!! Form::close() !!}

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('messages.ticker') }}</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            {!! Form::text('ticker', null, [
                                'class' => '',
                                'style' => 'border: none; margin: 0px;padding: 0px',
                                'required' => 'required',
                                'placeholder' => trans('messages.add_ticker')])
                            !!}
                        </li>
                        @foreach ($tickers as $ticker)
                            <li class="list-group-item">
                                {{ $ticker->text }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8 photo__gallery">
            <div class="panel panel-info"> <!-- Gallery -->
                <div class="panel-heading">
                    {{ 'Screens' }}
                </div>
                <div class="panel-body">
                    @foreach ($screenGroup->screens->chunk(3) as $set)
                        <div class="row">
                            @foreach ($set as $element)
                                <div class="col-md-4 gallery__image">
                                    <a href="/admin/screens/{{ $element->id }}/edit"</a>
                                        <img src="/{{ $element->photo->thumb_path }}" alt="">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div> <!-- File upload -->
            <form action="/admin/screengroups/{{ $screenGroup->id }}/addphoto"
                method="POST"
                class="dropzone"
                id="addImageForm"
            >
            {{ csrf_field() }}
            </form>
        </div>
        </div>
    </div>

    <!-- Modal -->
    @include('events.meta.__form')

@stop

@section('footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.min.js"></script>
    <script type="text/javascript" src="/js/ticker.js"></script>
    <script>
    Dropzone.options.addImageForm = {
        paramName: 'photo',
        maxFileSize: 10,
        acceptedFiles: '.jpg,.jpeg,.png,.bmp'
    };
    </script>
@stop