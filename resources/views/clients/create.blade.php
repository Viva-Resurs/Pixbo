@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add Client' }}</h1>

{!! Form::open(['route' => 'clients.store']) !!}
    @include ('clients.__form', ['submitButtonText' => 'Add'])
{!! Form::close() !!}
@stop