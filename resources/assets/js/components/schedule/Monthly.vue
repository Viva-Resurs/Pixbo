<template>

    <div class="column">

        <frequency :frequency.sync="event.frequency" type="month"></frequency>

        <div class="schedule_group">
            <label class="schedule_label">
                {{ trans('schedule.week') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_week') }}"></span>
            </label>
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
                                    :options="weekdays1"
                                    :type="type"
                                    classes="schedule_input"
                    >
                    </model-selector>
                </div>
            </div>
        </div>

        <div class="schedule_group">
             <model-selector :selected.sync="event.days_before_event"
                            :options="days_before"
                            type="day"
                            classes="schedule_input"
            >
                <div slot="label">
                    <label for="inputDays_before" class="schedule_label">
                        {{ trans('schedule.days_before_event') }}
                        <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_days_before') }}"></span>
                    </label>
                </div>
            </model-selector>
        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import Frequency from './Frequency.vue'
    import ModelSelector from '../ModelSelector.vue'
    import { ordering, weekdays1, days_before } from '../../option_arrays'
    
    export default {

        name: 'Monthly',

        props: [ 'event' ],

        components: { Frequency, ModelSelector },

        data: function() {
            return {
                ordering: ordering,
                weekdays1: weekdays1,
                days_before: days_before
            }
        }

    }
</script>
