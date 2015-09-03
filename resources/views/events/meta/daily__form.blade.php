<div class="daily">
    <div class="form-group">
        {!! Form::label('frequency', 'Every: ') !!}
        {!! Form::number('frequency', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {{ 'th day.' }}
        <small class="text-danger">{{ $errors->first('frequency') }}</small>
    </div>
</div>

<hr/>