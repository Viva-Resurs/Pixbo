@extends('admin')

@section('title')
    Screen index
@stop


@section('content')

<h1 class="page-header">{{ "Screen Index" }}</h1>
{!! link_to_route_html('screens.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-default']) !!}
@include('screens.__list')

@stop