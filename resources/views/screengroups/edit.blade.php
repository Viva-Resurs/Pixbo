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
                        {{ 'Info' }}
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        {!! Form::model($screenGroup, ['method' => 'PATCH', 'route' => ['admin.screengroups.update', $screenGroup->id]]) !!}
                            @include ('screengroups.__form', ['submitButtonText' => 'Edit'])
                        {!! Form::close() !!}
                    </table>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ 'Event' }}
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            @foreach($screenGroup->event as $event)
                                {!! Form::model($event, ['method' => 'PATCH', 'route' => ['admin.events.update', $event->id]]) !!}
                                    @include ('events.__form', ['submitButtonText' => 'Edit'])
                                {!! Form::close() !!}
                            @endforeach
                        </tbody>
                    </table>
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
                                    <a href="/admin/screens/{{ $element->id }}"</a>
                                        <img src="/{{ $element->photo->thumb_path }}" alt="">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
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
@stop

@section('footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script>
    Dropzone.options.addImageForm = {
        paramName: 'photo',
        maxFileSize: 10,
        acceptedFiles: '.jpg,.jpeg,.png,.bmp'
    };
    </script>
@stop