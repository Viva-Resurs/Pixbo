<template>
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">
                {{ 'messages.frequency' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_frequency_month_tooltip' }}"></span>
            </label>
            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputRecur_day_num">
                {{ 'messages.week' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_week_tooltip' }}"></span>
            </label>
            <select v-model="monthly_day_num" value="1" name="recur_day_num" id="inputRecur_day_num" class="form-control">
                <option value="1">{{ 'messages.first' }}</option>
                <option value="2">{{ 'messages.second' }}</option>
                <option value="3">{{ 'messages.third' }}</option>
                <option value="4">{{ 'messages.fourth' }}</option>
                <option value="5">{{ 'messages.last' }}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputRecur_day">
                {{ 'messages.day' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_day_tooltip' }}"></span>
            </label>
            <select v-model="event.recur_day" name="recur_day" id="inputRecur_day" class="form-control">
                <option value="1">{{ 'messages.monday' }}</option>
                <option value="2">{{ 'messages.tuesday' }}</option>
                <option value="3">{{ 'messages.wednesday' }}</option>
                <option value="4">{{ 'messages.thursday' }}</option>
                <option value="5">{{ 'messages.friday' }}</option>
                <option value="6">{{ 'messages.saturday' }}</option>
                <option value="0">{{ 'messages.sunday' }}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputDays_before" class="control-label">
                {{ 'messages.days_before_event' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_days_ahead_tooltip' }}"></span>
            </label>
            <input v-model="event.days_before_event" type="number" name="days_before" id="inputDays_before" class="form-control" v-bind:value="event.days_before_event" min='0' max='30' step='1' title="">
        </div>
    </div>
</template>