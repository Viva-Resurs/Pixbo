<div class="form-group">
    {!! Form::label('name', trans('messages.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <div class="checkbox @if($errors->first('scheduled')) has-error @endif">
            <label for="scheduled">
                {!! Form::checkbox('scheduled', null, null, ['id' => 'scheduled']) !!} {{ 'Scheduled' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('scheduled') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
</div>