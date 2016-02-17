@extends('admin')

@section('title')
    Ticker index
@stop


@section('content')

    @foreach ($tickers as $card)
        @include('tickers.ticker__card', ['from' => 'ticker'])
    @endforeach

@stop