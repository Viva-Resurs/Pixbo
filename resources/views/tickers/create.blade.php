@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ trans('messages.add_ticker') }}
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'admin.tickers.store']) !!}
                    @include ('tickers.__form', ['submitButtonText' => trans('messages.add')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop