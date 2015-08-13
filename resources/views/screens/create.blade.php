@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add Screen' }}</h1>

{!! Form::open(['route' => 'admin.screens.store']) !!}
    @include ('screens.__form', ['submitButtonText' => 'Add'])
{!! Form::close() !!}
@stop
