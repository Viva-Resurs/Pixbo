<template>
    <frequency :frequency.sync="frequency" type="month"></frequency>

    <div class="form-group">
            <label for="inputRecur_day_num">
                {{ trans('schedule.week') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_week') }}"></span>
            </label>
        <div class="form-group">
            <div class="form-group col-md-6">
                <select v-model="monthly_day_num" value="1" name="recur_day_num" id="inputRecur_day_num" class="form-control">
                    <option v-for="order in ordering" :value="$index+1">{{ trans(order) }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <select v-model="recur_day" name="recur_day" id="inputRecur_day" class="form-control">
                    <option v-for="day in weekday" :value="$index+1">{{ trans(day+'1') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="inputDays_before" class="control-label">
                {{ trans('schedule.days_before_event') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_days_before') }}"></span>
            </label>
            <select v-model="days_before_event" name="days_before" id="inputDays_before" class="form-control">
                <option v-for="day in days_before" :value="$index">
                {{ trans(day.name) + " " + trans('schedule.day',day_type($index)).toLowerCase() }}
                </option>
            </select>
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    import { ordering, weekdays, days_before } from '../../option_arrays'
    export default {
        props: [
            'frequency',
            'monthly_day_num',
            'day_num',
            'days_before_event',
            'recur_day'
        ],

        components: { Frequency },

        methods : {
            day_type(index) {
                return (index>1) ? 2 : 1;
            }
        },

        data() {
            return {
                ordering: ordering,
                weekday: weekdays,
                days_before: days_before
            }
        }
    }
</script>