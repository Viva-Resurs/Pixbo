@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')

    <h1 class="page-header">{{ "ScreenGroup Index" }}</h1>

    {!! link_to_route_html('admin.screengroups.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-primary']) !!}
    <br>
    @if (Count($data))
        {!!
            toTable($data->toArray()['data'], array(
            'attributes' => array('class' => 'table'),
            'only' => array('id', 'name', 'created_at'),
            'action' => 'screengroups.actions'
       ))
    !!}
    {!! $data->render() !!}
@else
{{ "No screen groups found." }}
@endif

@stop
