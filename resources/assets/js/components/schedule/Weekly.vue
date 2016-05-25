<template>
    <frequency :frequency.sync="frequency"></frequency>

    <div class="form-group">
        <div class="form-group">
            <label class="control-label">
                {{ trans('schedule.weekdays') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_frequency_week_tooltip') }}"></span>
            </label>

            <br>
            <label v-for="day in weekdays">
                {{ trans(day.text) }}
                <input v-model="day_num" type="checkbox" :value="day.value" :id="$index">
            </label>
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    export default {
        props: ['day_num', 'frequency'],
        components: { Frequency },
        data() {
            return {
                weekdays: [
                    {text: 'schedule.monday_short', value: 1},
                    {text: 'schedule.tuesday_short', value: 2},
                    {text: 'schedule.wednesday_short', value: 3},
                    {text: 'schedule.thursday_short', value: 4},
                    {text: 'schedule.friday_short', value: 5},
                    {text: 'schedule.saturday_short', value: 6},
                    {text: 'schedule.sunday_short', value: 0},
                ],
            }
        },
    }
</script>