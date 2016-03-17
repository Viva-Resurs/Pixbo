@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')
  	@foreach ($screengroups as $card)
       	@include('screengroups.screengroup__card')
    @endforeach

    @can('view_dashboard')

    @endcan
@stop