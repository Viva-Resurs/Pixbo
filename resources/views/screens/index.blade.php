@extends('admin')

@section('title')
    Screen index
@stop


@section('content')

    @include('screens.screens__card', ['from' => 'screen'])

@stop
