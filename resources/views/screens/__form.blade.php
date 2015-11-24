<div class="form-group">
    {!! Form::label('name', trans('messages.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    {!! Form::hidden('scheduled', '0') !!}
    {!! Form::label('scheduled', trans('messages.scheduled')) !!}
    {!! Form::checkbox('scheduled', 1, null,['value' => '1', 'id' => 'scheduled']) !!}
    <small class="text-danger">{{ $errors->first('scheduled') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
</div>