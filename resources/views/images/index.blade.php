@extends('admin')


@section('header')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('title')
    Images index
@stop


@section('content')

    <h1 class="page-header">{{ "Images Index" }}</h1>

    {!! link_to_route_html('images.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-primary']) !!}
    <br>
    @if (Count($data))
        {!!
            toTable($data->toArray()['data'], array(
                'attributes' => array('class' => 'table'),
                'only' => array('id', 'path', 'archived', 'created_at'),
                'action' => 'images.actions'
            ))
        !!}
        {!! $data->render() !!}
    @else
        {{ "No images found." }}
    @endif

<form action="{{ action('ImagesController@store') }}"
      method="POST"
      class="dropzone"
      id="upload_photos"
>
    {{ csrf_field() }}
</form>
@stop

@section('footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
@stop
