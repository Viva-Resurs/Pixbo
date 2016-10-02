@extends('admin')

@section('title')
    {{ trans('messages.edit_user') }}
@stop

@section('content')

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('messages.edit_user') }}
            </div>
        	<div class="panel-body">
                {!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user->id]]) !!}
                @include ('users.__form', ['submitButtonText' => trans('messages.edit')])
                {!! Form::close() !!}
        	</div>
        </div>

    </div>
@stop
