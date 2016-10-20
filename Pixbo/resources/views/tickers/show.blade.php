@extends('admin')

@section('title')
{{ trans("messages.show_ticker") }}
@stop


@section('content')

<h1 class="page-header">{{ trans("messages.show_ticker") }}</h1>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <schedule id="{{ $ticker->id }}" model="tickers"></schedule>
                @include('shared.schedule.template', ['item' => $ticker, 'model' => 'tickers'])
            </div>

            <div class="panel-footer">
                @include('shared.schedule.submit_button', ['item' => $ticker, 'model' => 'tickers'])
            </div>

        </div>
    </div>
</div>
@stop