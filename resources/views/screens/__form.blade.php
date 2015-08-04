<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    {!! Form::label('screengroup_id', 'Screen Group') !!}
    {!! Form::select('screengroup_id', $screenGroups, null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('screengroup_id') }}</small>
</div>

<div class="form-group">
    {!! Form::label('image_id', 'Image:') !!}
    {!! Form::number('image_id', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('image_id') }}</small>
</div>

<div class="form-group">
    {!! Form::label('event_id', 'Event:') !!}
    {!! Form::number('event_id', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('event_id') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
</div>