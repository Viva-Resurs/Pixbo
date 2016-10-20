@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('messages.add_user') }}
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'admin.users.store']) !!}
                    @include ('users.__form', ['submitButtonText' => trans('messages.add')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
