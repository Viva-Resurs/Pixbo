@extends('admin')


@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('title')
    ScreenGroup index
@stop


@section('content')

    <h1 class="page-header">{{ trans("messages.edit_screen_group") }}</h1>

    <div class="row">
        <div class="col-md-4">

            @include('screengroups.edit.edit__info')
            @include('shared.edit__event')

        </div>

        <div class="col-md-8">


            <!-- Add ticker here -->
            @include('screengroups.edit.edit__screens')

        </div>

    <!-- Modal -->
    @include('events.meta.__form')

@stop

@section('footer')

    <!-- Required for screen uploading -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script>
        Dropzone.options.addImageForm = {
            paramName: 'photo',
            maxFileSize: 10,
            acceptedFiles: '.jpg,.jpeg,.png,.bmp',
            dictDefaultMessage: 'Drop files here to be uploaded.'
        };
    </script>

@stop