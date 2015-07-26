@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')

<h1 class="page-header">{{ "ScreenGroup Index" }}</h1>

@include('screengroups.__list')

@stop