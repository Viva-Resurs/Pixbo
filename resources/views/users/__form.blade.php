<div class="form-group">
    <label for="name">{{ trans('messages.name') }}:</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    {!! Form::label('password', trans('auth.password')) !!}
    {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('password') }}</small>
</div>
<div class="form-group">
    {!! Form::label('password_confirmation', trans('auth.repeat_password')) !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
</div>

<!-- You can't edit your own Role. -->
@if(!(auth()->user()->id === $user->id))
    <div class="form-group">
        {!! Form::label('role_id', trans_choice('messages.role', 1)) !!}
        {!! Form::select('role_id', $roles, $user->roles()->first()->id, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('role_id') }}</small>
    </div>
@endif

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>
