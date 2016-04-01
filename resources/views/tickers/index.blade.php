@extends('admin')

@section('title')
    Ticker index
@stop

@section('header')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
@stop


@section('content')

    @include('tickers.table', ['from' => 'tickers'])

@stop

@section('footer')

    @include('shared.datagrid', ['table_id' => 'tickers_table'])

@stop