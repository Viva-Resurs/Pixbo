@extends('admin')

@section('content')

    <h1 class="page-header">{{ trans('messages.add_ticker') }}</h1>

    <div class="row">
        <div class="col-md-6">
            {!! Form::open(['route' => 'admin.tickers.store']) !!}
                @include ('tickers.__form', ['submitButtonText' => trans('messages.add')])
            {!! Form::close() !!}
        </div>
    </div>
@stop