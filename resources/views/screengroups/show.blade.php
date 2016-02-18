@extends('admin')

@section('title')
    {{ trans_choice('messages.screen_group', 1) }}
@stop

@section('header')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
@stop

@section('content')
<h1 class="page_header">{{ $screengroup->name }}</h1>
    <div class="row">
        <h2>{{ trans_choice('messages.screen', 2) }}</h2>
        <hr>
            @foreach ($screengroup->screens as $card)
                @include('screens.screen__card', ['card' => $card, 'from' => 'screengroup'])
            @endforeach
    </div>
    <div class="row">
        <h2>{{ trans_choice('messages.ticker',2) }}</h2>
        <hr>
            @foreach($screengroup->tickers as $card)
                @include('tickers.ticker__card', ['card' => $card, 'from' => 'screengroup'])
            @endforeach
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
@stop