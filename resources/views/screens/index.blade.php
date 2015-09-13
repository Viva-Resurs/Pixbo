@extends('admin')

@section('title')
    Screen index
@stop


@section('content')

    <h1 class="page-header">{{ "Screen Index" }}</h1>
    {!! link_to_route_html('admin.screens.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-primary']) !!}
    <br>
    @if (Count($data))
        {!!
            toTable($data->toArray()['data'], array(
            'attributes' => array('class' => 'table'),
            'only' => array('id', 'name'),
            'action' => 'screens.actions'
       ))
    !!}
    @else
    {{ "No screens found." }}
    @endif

@stop
