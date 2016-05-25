<template>
    <div class="form-group">
        <model-selector :selected.sync="frequency"
                        :options="frequency_options"
        >
            <div slot="label">
                <label for="inputFrequency" class="control-label">
                    {{ trans('schedule.frequency') }}
                    <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_frequency_tooltip') }}"></span>
                </label>
            </div>
        </model-selector>
    </div>
</template>

<script>
    import ModelSelector from '../ModelSelector.vue'
    import { frequency_options } from '../../option_arrays'

    export default {
        props: ['frequency'],
        components: { ModelSelector },
        data() {
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

        ready() {
            this.update()
        }
    }
</script>