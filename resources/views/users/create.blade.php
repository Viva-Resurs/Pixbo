@extends('admin')

@section('content')

    <h1 class="page-header">{{ trans('messages.add_user') }}</h1>

    <div class="row">
        <div class="col-md-6">
            {!! Form::open(['route' => 'admin.users.store']) !!}
                @include ('users.__form', ['submitButtonText' => trans('messages.add')])
            {!! Form::close() !!}
        </div>
    </div>
@stop
