@extends('admin')

@section('content')

    <h1 class="page-header">{{ trans('messages.edit_user') }}</h1>

    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user->id]]) !!}
    @include ('users.__form', ['submitButtonText' => trans('messages.edit')])
    {!! Form::close() !!}
@stop
