@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')

<div class="content">

    <div class="row">
        @include('tickers.ticker__card')
    </div>

    @can('view_dashboard')

    @endcan
</div>

@stop