@extends('admin')

@section('title')
    {{ trans_choice('messages.screen_group', 1) }}

@stop

@section('header')
    @include('shared.datagrid', ['table_id_list_string' => 'clients_table,tickers_table'])
@stop

@section('content')
    <h1 class="page_header">
        {{ $screengroup->name }}
        @include('screengroups.actions', ['item' => $screengroup, 'from' => 'screengroups'])
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