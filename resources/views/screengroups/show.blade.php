@extends('admin')

@section('title')
    {{ trans('messages.screengroup_title') }}
@stop

@section('header')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
@stop

@section('content')
    <div class="row">
        <h2>{{ trans_choice('messages.screen', 2) }}</h2>
        <hr>
        @include('screens.screens__card', ['screens' => $screengroup->screens, 'from' => 'screengroup'])
    </div>
    <div class="row">
        <h2>{{ trans_choice('messages.ticker',2) }}</h2>
        <hr>
        @include('tickers.ticker__card', ['tickers' => $screengroup->tickers])
    </div>
    @can('edit_clients')
        <div class="row">
            <h2>{{ trans_choice('messages.client', 2) }}</h2>
            <hr>
            @include('clients.table', ['list' => $screengroup->clients])
        </div>
    @endcan
@stop

@section('footer')
    @include('shared.datagrid', ['table_id' => 'client_table'])
@stop