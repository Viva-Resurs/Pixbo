@extends('admin')

@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('content')

<h1 class="page-header">{{ trans('messages.add_screen') }}</h1>

@include('shared/alert')
<div> <!-- File upload -->
    <form action="/admin/screens/addphoto"
        method="POST"
        class="dropzone"
        id="addImageForm"
    >
        {{ csrf_field() }}
    </form>
</div>
@stop

@section('footer')

    <!-- Required for screen uploading -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script>
        Dropzone.options.addImageForm = {
            paramName: 'photo',
            maxFileSize: 10,
            acceptedFiles: '.jpg,.jpeg,.png,.bmp',
            dictDefaultMessage: '{{ trans("messages.upload_files") }}',
            init: function() {
                this.on('complete', function(response) {
                    vue_instance.addAlert(JSON.parse(response.xhr.response));
                });
            }
        };
    </script>

@stop