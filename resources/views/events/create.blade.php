@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add Event' }}</h1>

{!! Form::open(['route' => 'events.store']) !!}
    @include ('events.__form', ['submitButtonText' => 'Add'])
{!! Form::close() !!}
@stop