@extends('admin')

@section('title')
    Client index
@stop

@section('header')
    @include('shared.datatables', ['table_id_list_string' => 'clients_table'])
@stop

@section('content')
	@include('clients.table', ['from' => 'clients'])
@stop