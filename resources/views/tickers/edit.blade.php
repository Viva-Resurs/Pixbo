@extends('admin')

@section('content')

    <h1 class="page-header">{{ trans('messages.edit_ticker') }}</h1>

    <div class="col-md-6">
        <div class="panel panel-info">
              <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('messages.info') }}</h3>
              </div>
              <div class="panel-body">
                    {!! Form::model($ticker, ['method' => 'PATCH', 'route' => ['admin.tickers.update', $ticker->id]]) !!}
                            @include ('tickers.__form', ['submitButtonText' => trans('messages.save')])
                    {!! Form::close() !!}
              </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="panel panel-info">
              <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('messages.image') }}</h3>
              </div>
              <div class="panel-body">

              </div>
        </div>
    </div>

    <div class="col-md-6">
        @include('shared.edit__event')
    </div>
    <div class="col-md-6">
      @include('screens.screengroups')
    </div>
@stop
