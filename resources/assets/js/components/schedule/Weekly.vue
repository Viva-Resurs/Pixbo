<template>
    <div>
        <frequency :frequency.sync="event.frequency" type="week"></frequency>

        <div>
            <!-- TODO: 'Fix Mån Tis Ons' in model-selector mode/dropdown title -->
                <model-selector :selected.sync="weekly_day_num"
                                :options="weekdays"
                                :type="type"
                                classes="schedule_input"
                                multiple="true"
                                mode="count > 3"
                >
                    <div slot="label">
                        <label class="schedule_label">
                            {{ trans('schedule.weekdays') }}
                            <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_week_days') }}"></span>
                        </label>
                    </div>
                </model-selector>
        </div>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'
    import { weekdays } from '../../option_arrays'
    import ModelSelector from '../ModelSelector.vue'
    export default {
        props: ['event', 'weekly_day_num'],
        components: { Frequency, ModelSelector },
        data() {
            return {
                weekdays: weekdays,
            }
        },
    }
</script>