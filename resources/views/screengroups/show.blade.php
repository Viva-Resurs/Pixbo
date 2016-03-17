@extends('admin')

@section('title')
    {{ trans_choice('messages.screen_group', 1) }}
@stop

@section('header')
    <script type="text/javascript" src="/js/vendor/dataTables/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/vendor/jquery.dataTables.min.css">
@stop

@section('content')
<h1 class="page_header">{{ $screengroup->name }}</h1>
    <div class="row">
        <h2>{{ trans_choice('messages.screen', 2) }}</h2>
        <hr>
            @if( count($screengroup->screens) > 0)
                @foreach ($screengroup->screens as $card)
                    @include('screens.screen__card', ['card' => $card, 'from' => 'screengroup'])
                @endforeach
            @else
                {{ trans('messages.no_images') }}
            @endif
    </div>
    <div class="row">
        <h2>{{ trans_choice('messages.ticker',2) }}</h2>
        <hr>
        @include('tickers.table', ['list' => $screengroup->tickers, 'from' => 'screengroup'])
    </div>
    @can('edit_clients')
        <div class="row">
            <h2>{{ trans_choice('messages.client', 2) }}</h2>
            <hr>
            @include('clients.table', ['list' => $screengroup->clients, 'from' => 'screengroup'])
        </div>
    @endcan
@stop

@section('footer')
    @include('shared.datagrid', ['table_id' => 'client_table'])
    @include('shared.datagrid', ['table_id' => 'ticker_table'])
@stop