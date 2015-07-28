@extends('admin')

@section('title')
    Client index
@stop


@section('content')

<h1 class="page-header">{{ "Client Index" }}</h1>
{!! link_to_route_html('clients.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-default']) !!}



@include('clients.__list')

@stop