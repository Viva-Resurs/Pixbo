
<div class="form-group">
    {!! Form::label('date', trans('messages.date')) !!}
    {!! Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('date') }}</small>
</div>

<div class="form-group">
    {!! Form::label('start_time', trans('messages.start')) !!}
    {!! Form::time('start_time', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('start_time') }}</small>
</div>

<div class="form-group">
    {!! Form::label('end_time', trans('messages.end')) !!}
    {!! Form::time('end_time', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('end_time') }}</small>
</div>

<div class="form-group">
    {!! Form::hidden('recurring', '0') !!}
    {!! Form::label('recurring', trans('messages.recurring')) !!}
    {!! Form::checkbox('recurring', 1, null,['value' => '1', 'id' => 'recurring']) !!}
    <small class="text-danger">{{ $errors->first('recurring') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>