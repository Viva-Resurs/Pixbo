@extends('admin')

@section('title')
   {{ trans('messages.screen_group_index') }}
@stop


@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{ trans("messages.edit_screen_group") }}</h1>
        </div>
        <div class="panel-body">
            {!! Form::model($screengroup, ['method' => 'PATCH', 'route' => ['admin.screengroups.update', $screengroup->id], 'class' => 'form-horizontal']) !!}
                @include('screengroups.__form')
            {!! Form::close() !!}
        </div>
    </div>
@stop