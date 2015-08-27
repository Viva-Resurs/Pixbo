@extends('admin')


@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('title')
ScreenGroup index
@stop


@section('content')

<h1 class="page-header">{{ "ScreenGroup Show" }}</h1>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    {{ 'Info' }}
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ 'Id' }}</td>
                            <td>{{ $screenGroup->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Name' }}</td>
                            <td>{{ $screenGroup->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Desc' }}</td>
                            <td>{{ $screenGroup->desc }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Created' }}</td>
                            <td>{{ $screenGroup->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Modified' }}</td>
                            <td>{{ $screenGroup->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8 photo__gallery">
    <div class="panel panel-default">
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

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="/admin/screengroups/{{ $screenGroup->id }}/addphoto"
            method="POST"
            class="dropzone"
            id="addImageForm"
        >
        {{ csrf_field() }}
        </form>
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


@stop