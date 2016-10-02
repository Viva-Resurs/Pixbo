@extends('admin')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('messages.add_client') }}
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'admin.clients.store']) !!}
                        @include ('clients.__form', ['submitButtonText' => 'Add'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
