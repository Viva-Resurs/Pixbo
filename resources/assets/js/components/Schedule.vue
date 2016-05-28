<template>
    <form v-on:submit.prevent="attemptUpdateSchedule">
        <slot name="model_specific_setting">

        </slot>

        <div class="col-lg-6 col-md-6">

            <legend>
                {{ trans('screengroup.model', 1) }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_screengroup') }}"></span>
            </legend>
            <model-selector :selected.sync="selected_screengroups"
                            model="screengroup"
                            multiple="true"
                            mode="count > 3"
            >
            </model-selector>

            <period :event.sync="model.event"></period>

        </div>

        <div class="col-lg-6 col-md-6">

            <legend>
                {{ trans('schedule.repeat') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_repeat_type') }}"></span>
            </legend>
            <model-selector :selected.sync="model.event.recur_type"
                            :options="recur_options"
            ></model-selector>

            <component :is="model.event.recur_type"
                       :event.sync="event"
                       :weekly_day_num.sync="weekly_day_num"
            ></component>

            <!-- Summary -->
            <div class="row"></div>
            <label>{{ trans('general.summary') }}</label> {{ summary }}

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="" class="btn" @click="goBack()" v-if="emptyfields">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="" class="btn" @click="goBack()" v-if="!emptyfields">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="emptyfields">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>

        </div>
    </form>
</template>

<script>
    import RouterHelpers from '../mixins/RouterHelpers.vue'
    import { recur_options } from '../option_arrays'
    import ModelSelector from './ModelSelector.vue'

    import Period from './schedule/Period.vue';
    import none from './schedule/None.vue'
    import daily from './schedule/Daily.vue'
    import weekly from './schedule/Weekly.vue'
    import monthly from './schedule/Monthly.vue'
    import yearly from './schedule/Yearly.vue'

    export default {

        props: ['model'],

        mixins: ['RouterHelpers'],
        components: {
            Period,
            none,
            daily,
            weekly,
            monthly,
            yearly,
            ModelSelector
        },

        data: function() {
            return {
                recur_options: recur_options,
                selected_screengroups: [],
                weekly_day_num: []
            };
        },

        methods: {

            attemptUpdateSchedule() {
              this.updateSchedule();
            },

            updateSchedule: function () {
                // Update model stuff
                this.encodeModel();

                var self = this
                client({ path: `/${self.model.type}s/${self.model.id}`, entity: self.model, method: 'PUT'}).then(
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screen.updated'),
                            options: {theme: 'success'}
                        })
                        self.goBack()
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut')
                        } else {
                            self.$dispatch('alert', {
                                message: self.trans('screen.updated_fail'),
                                options: {theme: 'error'}
                            })
                        }
                    }
                )
            },
            encodeModel() {
                this.event.weekly_day_num = JSON.stringify(this.weekly_day_num);
                this.model.screengroups = this.selected_screengroups;
            },
            decodeModel() {
                if(this.model.screengroups != null || this.model.screengroups != [] || this.model.screengroups != "") {
                    var that = this;
                    this.model.screengroups.forEach(function(entry) {
                        that.selected_screengroups.push(entry.id)
                    })
                }
                this.weekly_day_num = JSON.parse(this.event.weekly_day_num)
            }
        },

        computed: {
            summary: function() {
                return 'summary_text';
            },
            event() {
                return this.model.event;
            },
            isValid: function() {
                // TODO: Fix Validation.
                // 
                // Return true if disabled should be set to button
                return false;
            },
            get_start_time() {
                return this.model.event.start_time;
            }
        },
        ready: function () {
            this.decodeModel();
        },
    };
</script>