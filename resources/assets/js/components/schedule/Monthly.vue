<template>
    <div>
        <frequency :frequency.sync="event.frequency" type="month"></frequency>

        <div>
            <div>
                <label class="schedule_label">
                    {{ trans('schedule.week') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_week') }}"></span>
                </label>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <model-selector :selected.sync="event.monthly_day_num"
                                    :options="ordering"
                                    :type="type"
                                    classes="schedule_input"
                    >
                    </model-selector>
                </div>
                <div class="col-md-6">
                    <model-selector :selected.sync="event.recur_day"
                                    :options="weekday"
                                    :type="type"
                                    classes="schedule_input"
                    >
                    </model-selector>
                </div>
            </div>
        </div>

        <div>
            <div>
                <label for="inputDays_before" class="schedule_label">
                    {{ trans('schedule.days_before_event') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_days_before') }}"></span>
                </label>
                <select v-model="event.days_before_event" name="days_before" id="inputDays_before" class="form-control">
                    <option v-for="day in days_before" :value="$index">
                    {{ trans(day.name) + " " + trans('schedule.day',day_type($index)).toLowerCase() }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    import ModelSelector from '../ModelSelector.vue'
    import { ordering, weekdays, days_before } from '../../option_arrays'
    export default {
        props: ['event'],

        components: { Frequency, ModelSelector },

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