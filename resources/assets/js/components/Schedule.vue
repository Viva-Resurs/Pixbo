<template>
    <form v-on:submit.prevent="attemptUpdateSchedule">
        <slot name="model_specific_setting">

        </slot>

        <div class="col-lg-6 col-md-6">

            <model-selector :selected.sync="selected_screengroups"
                                  model="screengroup"
                                  multiple="true"
                                  mode="count > 3"
            >
                <div slot="label">
                    {{ trans_choice('screengroup.model', 1) }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_screengroup') }}"></span>
                </div>
            </model-selector>

            <period :event.sync="model.event"></period>

        </div>

        <div class="col-lg-6 col-md-6">

            <model-selector :selected.sync="model.event.recur_type"
                                  :options="recur_options"
            >
                <div slot="label">
                    {{ trans('schedule.repeat') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_repeat_type') }}"></span>
                </div>
            </model-selector>

            <!-- Daily -->
            <template v-if="event.recur_type == 'daily'">
                <daily :frequency.sync="event.frequency"></daily>
            </template>

            <!-- Weekly -->
            <template v-if="event.recur_type == 'weekly'">
                <weekly
                        :day_num.sync="weekly_day_num"
                        :frequency.sync="event.frequency"
                ></weekly>
            </template>

            <!-- Monthly -->
            <template v-if="event.recur_type == 'monthly'">
                <monthly
                        :monthly_day_num.sync="monthly_day_num"
                        :frequency.sync="event.frequency"
                        :days_before_event.sync="event.days_before_event"
                        :recur_day.sync="event.recur_day"
                ></monthly>
            </template>

            <!-- Yearly -->
            <template v-if="event.recur_type == 'yearly'">
                <yearly :frequency.sync="event.frequency"></yearly>
            </template>

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
    import Daily from './schedule/Daily.vue'
    import Weekly from './schedule/Weekly.vue'
    import Monthly from './schedule/Monthly.vue'
    import Yearly from './schedule/Yearly.vue'

    export default {

        props: ['model'],

        mixins: ['RouterHelpers'],
        components: {
            Period,
            Daily,
            Weekly,
            Monthly,
            Yearly,
            ModelSelector
        },

        data: function() {
            return {
                recur_options: recur_options,
                selected_screengroups: [],
                weekly_day_num: [],
                monthly_day_num: '',

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
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screen.updated_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            },
            encodeModel() {
                switch (this.event.recur_type) {
                    case "weekly":
                        this.event.recur_day_num = JSON.stringify(this.weekly_day_num);
                            console.log("WEEKLY: " + this.event.day_num)
                        break;
                    case "monthly":
                        this.event.recur_day_num = JSON.stringify(this.monthly_day_num);
                            console.log("MONTHLY")
                        break;
                }
                this.model.screengroups = this.selected_screengroups;
            },
            decodeModel() {
                if(this.model.screengroups != null || this.model.screengroups != [] || this.model.screengroups != "") {
                    var that = this;
                    this.model.screengroups.forEach(function(entry) {
                        that.selected_screengroups.push(entry.id)
                    })
                }
                if(this.model.event.recur_day_num != null) {
                    var days = JSON.parse(this.event.recur_day_num)
                    switch (this.event.recur_type) {
                        case "weekly":
                            this.monthly_day_num = "1"
                            this.weekly_day_num = days;
                            break;
                        case "monthly":
                            this.monthly_day_num = days;
                            this.weekly_day_num = [];
                            break;
                    }
                } else {
                    this.monthly_day_num = "1";
                    this.weekly_day_num = [];
                }
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