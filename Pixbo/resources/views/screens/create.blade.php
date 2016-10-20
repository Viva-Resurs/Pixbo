@extends('admin')

@section('title')
    {{ trans("messages.add_screen") }}
@stop

@section('header')
    @include('screens.upload.header')
@stop

@section('content')

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ trans('messages.upload') }}
                    </div>
                </div>
                <div class="panel-body">
                    @include('screens.upload.content')
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
     @include('screens.upload.footer')
@stop