@extends('admin')

@section('title')
    Client index
@stop


@section('content')

<h1 class="page-header">{{ "Event Index" }}</h1>

{!! link_to_route_html('admin.events.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-primary']) !!}
<br>
@if (Count($data))
    {!!
        toTable($data->toArray()['data'], array(
        'attributes' => array('class' => 'table'),
        'only' => array('id', 'date', 'created_at'),
        'action' => 'events.actions'
   ))
!!}
{!! $data->render() !!}
@else
{{ "No events found." }}
@endif

@stop
