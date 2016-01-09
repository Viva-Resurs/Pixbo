@extends('admin')

@section('title')
{{ trans("messages.show_screen") }}
@stop


@section('content')

<h1 class="page-header">{{ trans("messages.show_screen") }}</h1>

<div class="row">
    <div class="col-sm-6 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="/{{ $screen->photo->path }}" style="max-height: 100%; max-width: 100%">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-default">
              <div class="panel-body">
                    <screen></screen>
              </div>
        </div>
    </div>
</div>
@stop