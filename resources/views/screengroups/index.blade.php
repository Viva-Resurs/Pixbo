@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')

<h1 class="page-header">{{ "ScreenGroup Index" }}</h1>
{!! link_to_route_html('screengroups.create', '<i rel="tooltip" title="Create" class="glyphicon glyphicon-plus">New</i>', null,['class' => 'btn btn-default']) !!}
@include('screengroups.__list')

@stop