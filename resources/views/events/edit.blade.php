@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Edit Event' }}</h1>

{!! Form::model($event, ['method' => 'PATCH', 'route' => ['admin.events.update', $event->id]]) !!}
    @include ('events.__form', ['submitButtonText' => 'Save'])
{!! Form::close() !!}
@stop
