<template>

    <div class="schedule_group">
        <model-selector :selected.sync="frequency"
                        :options="frequency_options"
                        :type="type"
                        classes="schedule_input"
        >
            <div slot="label">
                <label for="inputFrequency" class="schedule_label">
                    {{ trans('schedule.frequency') }}
                </label>
            </div>
        </model-selector>
    </div>

</template>

<script type="text/ecmascript-6">
    import ModelSelector from '../ModelSelector.vue'
    import { frequency_options, frequency_options1 } from '../../option_arrays'

    export default {

        name: 'Frequency',

        props: [ 'frequency', 'type' ],

        components: { ModelSelector },
        
        data: function() {
            return {
                frequency_options: frequency_options
            }
        },

        methods: {

            update() {

                this.$nextTick(function() {

                    $(this.$el.lastElementChild.firstElementChild).selectpicker({
                        size: 4,
                        iconBase: 'fa',
                        tickIcon: 'fa-check',
                        noneSelectedText: this.trans('general.nothing_selected'),
                    });
                    
                });

            }

        },

        ready: function() {

            if (this.type=='year')
                this.frequency_options = frequency_options1;

            this.update();

        }

    }
</script>
