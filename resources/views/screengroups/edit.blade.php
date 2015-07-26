@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Edit ScreenGroup' }}</h1>

{!! Form::model($screenGroup, ['method' => 'PATCH', 'route' => ['screengroups.update', $screenGroup->id]]) !!}
    @include ('screengroups.__form', ['submitButtonText' => 'Edit'])
{!! Form::close() !!}
@stop