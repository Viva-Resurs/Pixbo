<template v-if="event.recur_type == 'monthly'">
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">
                {{ trans('messages.frequency') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_month_tooltip') }}"></span>
            </label>
                <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
        <label for="inputRecur_day_num">
            {{ trans('messages.week') }}
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_week_tooltip') }}"></span>
        </label>
            <select v-model="monthly_day_num" value="1" name="recur_day_num" id="inputRecur_day_num" class="form-control">
                <option value="1">{{ trans('messages.first') }}</option>
                <option value="2">{{ trans('messages.second') }}</option>
                <option value="3">{{ trans('messages.third') }}</option>
                <option value="4">{{ trans('messages.fourth') }}</option>
                <option value="5">{{ trans('messages.last') }}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputRecur_day">
                {{ trans('messages.day') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_day_tooltip') }}"></span>
            </label>
            <select v-model="event.recur_day" name="recur_day" id="inputRecur_day" class="form-control">
                <option value="1">{{ trans('messages.monday') }}</option>
                <option value="2">{{ trans('messages.tuesday') }}</option>
                <option value="3">{{ trans('messages.wednesday') }}</option>
                <option value="4">{{ trans('messages.thursday') }}</option>
                <option value="5">{{ trans('messages.friday') }}</option>
                <option value="6">{{ trans('messages.saturday') }}</option>
                <option value="0">{{ trans('messages.sunday') }}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputDays_before" class="control-label">
                {{ trans('messages.days_before_event') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_days_ahead_tooltip') }}"></span>
            </label>
            <input v-model="event.days_before_event" type="number" name="days_before" id="inputDays_before" class="form-control" v-bind:value="event.days_before_event" min='0' max='30' step='1' title="">
        </div>
    </div>
</template>