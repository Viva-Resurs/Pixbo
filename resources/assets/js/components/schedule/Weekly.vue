<template>
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">
                {{ trans('schedule.frequency') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_frequency_week_tooltip') }}"></span>
            </label>
            <input v-model="frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label class="control-label">
                {{ trans('schedule.weekdays') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_frequency_week_tooltip') }}"></span>
            </label>

            <br>
            <label v-for="day in weekdays">
                {{ trans(day.text) }}
                <input v-model="weekly_day_num" type="checkbox" :value="day.value">
            </label>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['weekly_day_num', 'frequency'],
        data() {
            return {
                weekdays: [
                    {text: 'messages.monday_short', value: 1},
                    {text: 'messages.tuesday_short', value: 2},
                    {text: 'messages.wednesday_short', value: 3},
                    {text: 'messages.thursday_short', value: 4},
                    {text: 'messages.friday_short', value: 5},
                    {text: 'messages.saturday_short', value: 6},
                    {text: 'messages.sunday_short', value: 0},
                ],
            }
        },
        created() {
        }
    }
</script>