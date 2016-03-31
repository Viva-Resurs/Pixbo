@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')
  	@foreach ($screengroups as $card)
       	@include('screengroups.screengroup__card', ['from' => 'screengroups'])
    @endforeach
@stop