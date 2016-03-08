@extends('admin')

@section('title')
    Screen index
@stop


@section('content')
    @foreach ($screens as $card)
        @include('screens.screen__card', ['from' => 'screen'])
    @endforeach

@stop
