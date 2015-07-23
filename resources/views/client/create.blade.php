@extends('admin')

@section('content')

<h1 class="page-header">{{ 'Add Client' }}</h1>

{!! Form::open() !!}
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    {!! Form::label('ip_address', 'IP Address') !!}
    {!! Form::text('ip_address', null, ['class' => 'form-control', 'placeholder' => 'x.x.x.x']) !!}
    <small class="text-danger">{{ $errors->first('ip_address') }}</small>
</div>

<div class="form-group">
    {!! Form::label('mac_address', 'MAC Address') !!}
    {!! Form::text('mac_address', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'HH:HH:HH:HH:HH:HH']) !!}
    <small class="text-danger">{{ $errors->first('mac_address') }}</small>
</div>

<div class="form-group">
    {!! Form::label('screen_group_id', 'Screen Group') !!}
    {!! Form::number('screen_group_id', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('screen_group_id') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
    {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
</div>

{!! Form::close() !!}
@stop