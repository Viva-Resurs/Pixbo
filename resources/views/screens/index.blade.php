@extends('admin')

@section('title')
    Screen index
@stop


@section('content')

<h1 class="page-header">{{ "Screen Index" }}</h1>
{!! link_to_route_html('screens.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-default']) !!}
<br>
@if (Count($data))
    {{
        toTable($data->toArray(), array(
        'attributes' => array('class' => 'table'),
        'only' => array('id', 'name', 'created_at'),
        'action' => 'screens.action'
   ))
}}
@else
{{ "No screens found." }}
@endif

@stop