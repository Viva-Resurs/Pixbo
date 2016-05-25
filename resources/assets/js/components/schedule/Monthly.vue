<template>
    <frequency :frequency.sync="frequency"></frequency>

    <div class="form-group">
        <div class="form-group">
            <label for="inputRecur_day_num">
                {{ trans('schedule.week') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_week_tooltip') }}"></span>
            </label>
            <select v-model="monthly_day_num" value="1" name="recur_day_num" id="inputRecur_day_num" class="form-control">
                <option v-for="order in ordering" :value="$index+1">{{ trans(order) }}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputRecur_day">
                {{ trans('schedule.day') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_day_tooltip') }}"></span>
            </label>
            <select v-model="recur_day" name="recur_day" id="inputRecur_day" class="form-control">
                <option v-for="day in weekday" :value="$index+1">{{ trans(day) }}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputDays_before" class="control-label">
                {{ trans('schedule.days_before_event') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_days_ahead_tooltip') }}"></span>
            </label>
            <input v-model="days_before_event" type="number" name="days_before" id="inputDays_before" class="form-control" v-bind:value="days_before_event" min='0' max='30' step='1' title="">
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    export default {
        props: [
            'monthly_day_num',
            'frequency',
            'days_before_event',
            'recur_day'
        ],

        components: { Frequency },

        data() {
            return {
                ordering: [
                        'schedule.first',
                        'schedule.second',
                        'schedule.third',
                        'schedule.fourth',
                        'schedule.last'
                ],
                weekday: [
                        'schedule.monday',
                        'schedule.tuesday',
                        'schedule.wednesday',
                        'schedule.thursday',
                        'schedule.friday',
                        'schedule.saturday',
                        'schedule.sunday'
                ]
            }
        }
    }
</script>