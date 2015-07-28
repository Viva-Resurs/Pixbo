@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Edit Screen' }}</h1>

{!! Form::model($screen, ['method' => 'PATCH', 'route' => ['screens.update', $screen->id]]) !!}
    @include ('screens.__form', ['submitButtonText' => 'Edit'])
{!! Form::close() !!}
@stop