<div class="form-group">
    <label for="text">{{ trans('messages.text') }}:</label>
    {!! Form::text('text', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>
