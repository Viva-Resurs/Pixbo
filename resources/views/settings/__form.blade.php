<div class="form-group">
    <label for="password">{{ trans('auth.password') }}:</label>
    {!! Form::password('password', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('password') }}</small>
</div>

<div class="form-group">
    <label for="desc">{{ trans('auth.repeat_password') }}:</label>
    {!! Form::password('repeat_password', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('repeat_password') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>
