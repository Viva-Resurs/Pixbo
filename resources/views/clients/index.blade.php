@extends('admin')

@section('title')
    Client index
@stop


@section('content')

<h1 class="page-header">{{ "Client Index" }}</h1>

{!! link_to_route_html('admin.clients.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-primary']) !!}
<br>
@if (Count($data))
    {!!
        toTable($data->toArray()['data'], array(
        'attributes' => array('class' => 'table'),
        'only' => array('id', 'name', 'ip_address', 'created_at'),
        'action' => 'clients.actions'
   ))
!!}
{!! $data->render() !!}
@else
{{ "No clients found." }}
@endif

@stop
