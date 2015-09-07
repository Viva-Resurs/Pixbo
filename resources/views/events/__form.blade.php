@include('shared.alert')

<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('date') }}</small>
</div>

<div class="form-group">
    {!! Form::label('start_time', 'Start:') !!}
    {!! Form::text('start_time', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('start_time') }}</small>
</div>

<div class="form-group">
    {!! Form::label('end_time', 'End:') !!}
    {!! Form::text('end_time', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('end_time') }}</small>
</div>

<div class="form-group">
    <div class="checkbox">
        <label for="recurring">
            {!! Form::checkbox('recurring', null, null, ['id' => 'recurring']) !!} Recurring
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('recurring') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>