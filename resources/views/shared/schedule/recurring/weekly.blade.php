<template v-if="event.recur_type == 'weekly'">
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">
                {{ trans('messages.frequency') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_week_tooltip') }}"></span>
            </label>
                <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label class="control-label">
                {{ trans('messages.weekdays') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_week_tooltip') }}"></span>
            </label>

            <br>
            <label>
                {{ trans('messages.monday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="1">
            </label>
            <label>
                {{ trans('messages.tuesday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="2">
            </label>
            <label>
                {{ trans('messages.wednesday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="3">
            </label>
            <label>
                {{ trans('messages.thursday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="4">
            </label>
            <label>
                {{ trans('messages.friday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="5">
            </label>
            <label>
                {{ trans('messages.saturday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="6">
            </label>
            <label>
                {{ trans('messages.sunday_short') }}
                <input v-model="weekly_day_num" type="checkbox" value="0">
            </label>
        </div>
    </div>
</template>