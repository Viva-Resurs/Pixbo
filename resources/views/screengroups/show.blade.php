@extends('admin')

@section('title')
    {{ trans_choice('messages.screen_group', 1) }}

@stop

@section('header')
    @include('shared.datatables', ['table_id_list_string' => 'clients_table,tickers_table'])
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{ $screengroup->name }}

                @include('shared.actions', ['model' => 'admin.screengroups', 'item' => $screengroup, 'from' => 'screengroups'])

            </h1>
        </div>
        <div class="panel-body">
            <h2>{{ trans_choice('messages.screen', 2) }}</h2>
            <hr>
                @if( count($screengroup->screens) > 0)
                    <screen-list url="/api/screengroup/{{$screengroup->id}}/screens"></screen-list>
                @else
                    {{ trans('messages.no_images') }}
                @endif
            
            <h2>{{ trans_choice('messages.ticker',2) }}</h2>
            <hr>
            @include('tickers.table', ['tickers' => $screengroup->tickers, 'from' => 'screengroups'])
            
            @can('view_clients')
                <h2>{{ trans_choice('messages.client', 2) }}</h2>
                <hr>
                @include('clients.table', ['list' => $screengroup->clients, 'from' => 'screengroups'])
            @endcan
        </div>
    </div>
@stop