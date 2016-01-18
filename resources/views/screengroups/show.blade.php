@extends('admin')

@section('title')
    {{ trans('messages.screengroup_title') }}
@stop


@section('content')
    @include('screens.screens__card', ['screens' => $screengroup->screens, 'from' => 'screengroup'])
    @include('tickers.ticker__card', ['tickers' => $screengroup->tickers])

@stop