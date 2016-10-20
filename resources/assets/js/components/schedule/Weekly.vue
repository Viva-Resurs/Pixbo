<template>

    <div class="column">

        <frequency :frequency.sync="event.frequency" type="week"></frequency>

        <div class="schedule_group">
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
                    </label>
                </div>
            </model-selector>
        </div>
        
    </div>

</template>

<script type="text/ecmascript-6">
    import Frequency from './Frequency.vue'
    import { weekdays } from '../../option_arrays'
    import ModelSelector from '../ModelSelector.vue'

    export default {

        name: 'Weekly',

        props: [ 'event', 'weekly_day_num' ],

        components: { Frequency, ModelSelector },
        
        data: function() {
            return {
                weekdays: weekdays,
            }
        }

    }
</script>
