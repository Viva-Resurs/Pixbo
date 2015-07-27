@include('shared.alert')


{!! Form::hidden('is_active', 0) !!}

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
    {!! Form::label('screengroup_id', 'Screen Group') !!}
    {!! Form::select('screengroup_id', $screenGroups, $client->screengroup_id, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('screengroup_id') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>