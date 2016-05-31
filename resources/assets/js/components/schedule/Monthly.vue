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
                            :options="days_before_converted"
                            formated="yes"
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
<script>
    import Frequency from './Frequency.vue'
    import ModelSelector from '../ModelSelector.vue'
    import { ordering, weekdays1, days_before } from '../../option_arrays'
    export default {
        props: ['event'],

        components: { Frequency, ModelSelector },

        methods : {
            day_type(index) {
                return (index>1) ? 2 : 1;
            },
            day_convert(){
                for (var i=0; i<this.days_before.length ; i++){
                    this.days_before_converted[i] = {
                        name : this.trans(this.days_before[i].name) + " " + this.trans('schedule.day',this.day_type(this.days_before[i].id)).toLowerCase(),
                        id   : this.days_before[i].id
                    };
                }
            }
        },

        created(){
            this.day_convert();
        },

        data() {
            return {
                ordering: ordering,
                weekdays1: weekdays1,
                days_before: days_before,
                days_before_converted: []
            }
        }
    }
</script>