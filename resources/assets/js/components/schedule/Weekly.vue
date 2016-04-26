<template>
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">
                {{ 'messages.frequency' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_frequency_week_tooltip' }}"></span>
            </label>
            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label class="control-label">
                {{ 'messages.weekdays' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_frequency_week_tooltip' }}"></span>
            </label>

            <br>
            <label>
                {{ 'messages.monday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="1">
            </label>
            <label>
                {{ 'messages.tuesday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="2">
            </label>
            <label>
                {{ 'messages.wednesday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="3">
            </label>
            <label>
                {{ 'messages.thursday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="4">
            </label>
            <label>
                {{ 'messages.friday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="5">
            </label>
            <label>
                {{ 'messages.saturday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="6">
            </label>
            <label>
                {{ 'messages.sunday_short' }}
                <input v-model="weekly_day_num" type="checkbox" value="0">
            </label>
        </div>
    </div>
</template>