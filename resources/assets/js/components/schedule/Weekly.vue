<template>
    <div>
        <frequency :frequency.sync="event.frequency" type="week"></frequency>

        <div class="form-group">
            <div class="form-group">
                <label class="control-label">
                    {{ trans('schedule.weekdays') }}
                    <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.tooltip_event_week_days') }}"></span>
                </label>

                <br>
                <label v-for="day in weekdays">
                    {{ trans(day.name) }}
                    <input v-model="weekly_day_num" type="checkbox" :value="day.id" :id="$index">
                </label>
            </div>
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    import { weekday_abbr } from '../../option_arrays'
    export default {
        props: ['event', 'weekly_day_num'],
        components: { Frequency },
        data() {
            return {
                weekdays:weekday_abbr
            }
        },
    }
</script>