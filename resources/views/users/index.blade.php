@extends('admin')

@section('title')
    User index
@stop

@section('header')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
@stop


@section('content')

	@include('users.table', ['from' => 'users'])

@stop

@section('footer')

	@include('shared.datagrid', ['table_id' => 'users_table'])

@stop