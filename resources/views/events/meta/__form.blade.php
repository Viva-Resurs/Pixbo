<div class="form-group">
    {!! Form::label('recur_start', 'Start:') !!}
    {!! Form::date('recur_start', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('recur_start') }}</small>
</div>

<div class="form-group">
    {!! Form::label('recur_end', 'End:') !!}
    {!! Form::date('recur_end', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('recur_end') }}</small>
</div>

<hr/>

<div class="checkbox">
    <label for="recur_type" class="checkbox">
        {!! Form::radio('recur_type', null,  true, [
            'class' => 'form-control',
            'id'    => 'daily',
        ]) !!} {{ 'daily' }}
    </label>

    <label for="recur_type" class="checkbox">
        {!! Form::radio('recur_type', null,  null, [
            'class' => 'form-control',
            'id'    => 'weekly',
        ]) !!} {{ 'weekly' }}
    </label>

    <label for="recur_type" class="checkbox">
        {!! Form::radio('recur_type', null,  null, [
            'class' => 'form-control',
            'id'    => 'monthly',
        ]) !!} {{ 'monthly' }}
    </label>

    <label for="recur_type" class="checkbox">
        {!! Form::radio('recur_type', null,  null, [
            'class' => 'form-control',
            'id'    => 'yearly',
        ]) !!} {{ 'yearly' }}
    </label>
</div>

<hr/>

@include('events.meta.daily__form')
@include('events.meta.weekly__form')
@include('events.meta.monthly__form')