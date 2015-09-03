<div class="monthly">
    <div class="checkbox">
        <label for="day" class="checkbox">
            {!! Form::radio('day', null,  true, [
                'class' => 'form-control',
                'id'    => 'day',
            ]) !!}
            {{ 'Day ' }}
            <div class="form-group">
                {!! Form::label('recur_day_num', 'Day') !!}
                {!! Form::number('recur_day_num', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('recur_day_num') }}</small>
            </div>
            <div class="form-group">
                {!! Form::label('frequency', ' every ') !!}
                {!! Form::number('frequency', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('frequency') }}</small>
                {{ 'th month.' }}
            </div>
        </label>
    </div>
    <div class="checkbox">
        <label for="every" class="checkbox">
            {!! Form::radio('day', null,  null, [
                'class' => 'form-control',
                'id'    => 'every',
            ]) !!}
            {{ 'The ' }}
        </label>
         <div class="form-group">
             {!! Form::label('recur_week', 'The') !!}
             {!! Form::select('recur_week', [
                'first' => 'first',
                'second' => 'second',
                'third' => 'third',
                'fourth' => 'fourth'
             ], null, ['class' => 'form-control', 'required' => 'required']) !!}
             <small class="text-danger">{{ $errors->first('recur_week') }}</small>
         </div>

        @include('events.meta.days__form')

        <div class="form-group">
            {!! Form::label('month_freq', 'every') !!}
            {!! Form::number('month_freq', null, ['class' => 'form-control', 'required' => 'required']) !!}
            <small class="text-danger">{{ $errors->first('month_freq') }}</small>
        {{ ' month(s)' }}
        </div>

    </div>
</div>

<hr/>