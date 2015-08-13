@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Edit Client' }}</h1>

{!! Form::model($client, ['method' => 'PATCH', 'route' => ['admin.clients.update', $client->id]]) !!}
    @include ('clients.__form', ['submitButtonText' => 'Edit'])
{!! Form::close() !!}
@stop
