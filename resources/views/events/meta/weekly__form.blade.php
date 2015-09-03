<div class="weekly">
    <div class="form-group">
        {!! Form::label('frequency', 'Every: ') !!}
        {!! Form::number('frequency', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('frequency') }}</small>
        {{ 'th week on: ' }}
    </div>
    @include('events.meta.days__form')
</div>

<hr/>