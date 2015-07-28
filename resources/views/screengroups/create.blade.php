@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add ScreenGroup' }}</h1>

{!! Form::open(['route' => 'screengroups.store']) !!}
    @include ('screengroups.__form', ['submitButtonText' => 'Add'])
{!! Form::close() !!}
@stop