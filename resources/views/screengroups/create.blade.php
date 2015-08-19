@extends('admin')

@section('content')

<h1 class="page-header">{{ trans('messages.add_screengroup') }}</h1>

<div class="row">
<div class="col-md-6">
    {!! Form::open(['route' => 'admin.screengroups.store']) !!}
        @include ('screengroups.__form', ['submitButtonText' => trans('messages.add')])
    {!! Form::close() !!}
</div>
@stop
