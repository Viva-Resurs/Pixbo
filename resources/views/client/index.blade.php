@extends('admin')

@section('title')
    Client index
@stop


@section('content')

<h1 class="page-header">{{ "Client Index" }}</h1>

@include('client.__list')

@stop