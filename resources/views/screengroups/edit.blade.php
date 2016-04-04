@extends('admin')

@section('title')
   {{ trans('messages.screen_group_index') }}
@stop


@section('content')

    <h1 class="page-header">{{ trans("messages.edit_screen_group") }}</h1>

    <div class="row">
        <div class="col-lg-12">
            {!! Form::model($screengroup, ['method' => 'PATCH', 'route' => ['admin.screengroups.update', $screengroup->id]]) !!}
                @include('screengroups.__form', ['submitButtonText' => trans('messages.save')])
            {!! Form::close() !!}
        </div>
    </div>
@stop