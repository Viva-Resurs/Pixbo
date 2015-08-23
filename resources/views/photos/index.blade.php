@extends('admin')


@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('title')
    Images index
@stop


@section('content')

    <h1 class="page-header">{{ "Images Index" }}</h1>

    {!! link_to_route_html('admin.photos.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-primary']) !!}
    <br>
    @if (Count($data))
        {!!
            toTable($data->toArray()['data'], array(
                'attributes' => array('class' => 'table'),
                'only' => array('id', 'name', 'archived', 'created_at'),
                'action' => 'photos.actions'
            ))
        !!}
        {!! $data->render() !!}
    @else
        {{ "No images found." }}
    @endif

<form action="{{ action('Admin\PhotosController@store') }}"
      method="POST"
      class="dropzone"
      id="addImageForm"
>
    {{ csrf_field() }}
</form>
@stop

@section('footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script>
    Dropzone.options.addImageForm = {
        paramName: 'image',
        maxFileSize: 10,
        acceptedFiles: '.jpg,.jpeg,.png,.bmp'
    };
    </script>
@stop
