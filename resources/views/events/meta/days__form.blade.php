<div class="form-group">
        <div class="checkbox">
            <label for="recur_day_0">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_0']) !!}
                {{ 'Monday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="recur_day_1">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_1']) !!}
                {{ 'Tuesday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="recur_day_2">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_2',]) !!}
                {{ 'Wednesday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="recur_day_3">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_3']) !!}
                {{ 'Thursday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="recur_day_4">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_4']) !!}
                {{ 'Friday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="recur_day_5">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_5']) !!}
                {{ 'Saturday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="recur_day_6">
                {!! Form::checkbox('recur_day[]', null, null, ['id' => 'recur_day_6']) !!}
                {{ 'Sunday' }}
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('recur_day') }}</small>
    </div>