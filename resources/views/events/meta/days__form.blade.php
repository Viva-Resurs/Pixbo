<div class="form-group">

        <label for="recur_day_0">
            {!! Form::checkbox('recur_day[]', "0", null, ['id' => 'recur_day_0']) !!}
            {{ trans('messages.monday_short') }}
        </label>
        <label for="recur_day_1">
            {!! Form::checkbox('recur_day[]', "1", null, ['id' => 'recur_day_1']) !!}
            {{ trans('messages.tuesday_short') }}
        </label>
        <label for="recur_day_2">
            {!! Form::checkbox('recur_day[]', "2", null, ['id' => 'recur_day_2',]) !!}
            {{ trans('messages.wednesday_short') }}
        </label>
        <label for="recur_day_3">
            {!! Form::checkbox('recur_day[]', "3", null, ['id' => 'recur_day_3']) !!}
            {{ trans('messages.thursday_short') }}
        </label>
        <label for="recur_day_4">
            {!! Form::checkbox('recur_day[]', "4", null, ['id' => 'recur_day_4']) !!}
            {{ trans('messages.friday_short') }}
        </label>
        <label for="recur_day_5">
            {!! Form::checkbox('recur_day[]', "5", null, ['id' => 'recur_day_5']) !!}
            {{ trans('messages.saturday_short') }}
        </label>
        <label for="recur_day_6">
            {!! Form::checkbox('recur_day[]', "6", null, ['id' => 'recur_day_6']) !!}
            {{ trans('messages.sunday_short') }}
        </label>
    </div>