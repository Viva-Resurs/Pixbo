@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add Client' }}</h1>

{!! Form::open(['route' => 'admin.clients.store']) !!}
    @include ('clients.__form', ['submitButtonText' => 'Add'])
{!! Form::close() !!}
@stop
