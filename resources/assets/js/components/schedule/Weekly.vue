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
                {{ trans(day.name) }}
                <input v-model="day_num" type="checkbox" :value="day.id" :id="$index">
            </label>
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    import { weekday_abbr } from '../../option_arrays'
    export default {
        props: ['day_num', 'frequency'],
        components: { Frequency },
        data() {
            return {
                weekdays:weekday_abbr
            }
        },
    }
</script>