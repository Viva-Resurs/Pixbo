@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add Client' }}</h1>

{!! Form::open() !!}
    @include ('clients.form', ['submitButtonText' => 'Add'])
{!! Form::close() !!}
@stop