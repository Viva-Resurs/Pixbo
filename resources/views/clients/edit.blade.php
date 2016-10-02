@extends('admin')

@section('content')

<h1 class="page-header">{{ trans('messages.edit_client') }}</h1>

{!! Form::model($client, ['method' => 'PATCH', 'route' => ['admin.clients.update', $client->id]]) !!}
    @include ('clients.__form', ['submitButtonText' => trans('messages.edit')])
{!! Form::close() !!}
@stop
