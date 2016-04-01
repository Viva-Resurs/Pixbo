@extends('admin')

@section('title')
    {{ trans_choice('messages.screen_group', 1) }}

@stop

@section('header')
    <script type="text/javascript" src="/js/vendor/dataTables/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/vendor/jquery.dataTables.min.css">
@stop

@section('content')
    <h1 class="page_header">
        {{ $screengroup->name }}
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    </h1>
    <div class="row">
        <h2>{{ trans_choice('messages.screen', 2) }}</h2>
        <hr>
            @if( count($screengroup->screens) > 0)
                @foreach ($screengroup->screens as $card)
                    @include('screens.screen__card', ['card' => $card, 'from' => 'screengroups'])
                @endforeach
            @else
                {{ trans('messages.no_images') }}
            @endif
    </div>
    <div class="row">
        <h2>{{ trans_choice('messages.ticker',2) }}</h2>
        <hr>
        @include('tickers.table', ['tickers' => $screengroup->tickers, 'from' => 'screengroups'])
    </div>
    @can('edit_clients')
        <div class="row">
            <h2>{{ trans_choice('messages.client', 2) }}</h2>
            <hr>
            @include('clients.table', ['list' => $screengroup->clients, 'from' => 'screengroups'])
        </div>
    @endcan
@stop

@section('footer')
    @include('shared.datagrid', ['table_id' => 'clients_table'])
    @include('shared.datagrid', ['table_id' => 'tickers_table'])
@stop