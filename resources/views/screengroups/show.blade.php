@extends('admin')

@section('title')
    {{ trans('messages.screengroup_title') }}
@stop


@section('content')
    @include('screengroups.screen__card', ['screens' => $screengroup->screens]);

@stop