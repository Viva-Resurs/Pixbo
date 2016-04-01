@extends('admin')

@section('title')
{{ trans("messages.show_ticker") }}
@stop


@section('content')

<h1 class="page-header">{{ trans("messages.show_ticker") }}</h1>

<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-default">
              <div class="panel-body">
                    <schedule id="{{ $ticker->id }}" model="tickers"></schedule>
                    @include('shared.schedule__template')
              </div>
        </div>
    </div>
</div>
@stop