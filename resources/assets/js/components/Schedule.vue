<template>

    <form class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateSchedule" name="myform" v-form>

        <div class="panel-body">

            <slot name="model_specific_setting">

            </slot>

            <div class="{{ (advancedMode) ? 'col-lg-6 col-md-6' : 'col-lg-12 col-md-12' }}">

                <div class="schedule_group">
                    <label for="text" class="schedule_label">
                        {{ trans('screengroup.model', 1) }}
                        <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_screengroup') }}"></span>
                    </label>
                    <model-selector :selected.sync="selected_screengroups"
                                    model="screengroup"
                                    multiple="true"
                                    mode="count > 3"
                                    classes="schedule_input"
                    >
                    </model-selector>
                </div>

                <div class="schedule_group">
                    <period :event.sync="model.event"></period>
                </div>

            </div>

            <div class="col-lg-6 col-md-6" v-show="advancedMode">

                <div class="schedule_group">
                    <label for="text" class="schedule_label">
                        {{ trans('schedule.repeat') }}
                        <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_repeat_type') }}"></span>
                    </label>
                    <model-selector :selected.sync="model.event.recur_type"
                                    :options="recur_options"
                                    classes="schedule_input"
                    >
                    </model-selector>
                </div>

                <component :is="model.event.recur_type"
                           :event.sync="event"
                           :weekly_day_num.sync="weekly_day_num"
                ></component>

                <div class="schedule_group">
                    <!-- Summary -->
                    <label class="schedule_label">{{ trans('general.summary') }}</label>
                    <div class="schedule_input">
                        {{ summary }}
                    </div>
                </div>

            </div>

        </div>

        <div class="panel-footer text-right">
                
            <button type="button" class="btn" @click="toggleMode" v-if="!advancedMode"> Avancerade alternativ </button>
            <button type="button" class="btn" @click="toggleMode" v-if="advancedMode"> Göm Avancerade alternativ </button>

            <button type="button" class="btn" @click="goBack()" v-if="myform.$pristine">
                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
            </button>
            <button type="button" class="btn" @click="goBack()" v-if="!myform.$pristine">
                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
            </button>
            <button type="submit" @keydown.enter.prevent="attemptUpdateSchedule" class="btn btn-primary">
                <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
            </button>

        </div>

    </form>

</template>

<script type="text/ecmascript-6">
    import RouterHelpers from '../mixins/RouterHelpers.vue'
    import { recur_options } from '../option_arrays'
    import ModelSelector from './ModelSelector.vue'

    import Period from './schedule/Period.vue'
    import none from './schedule/None.vue'
    import daily from './schedule/Daily.vue'
    import weekly from './schedule/Weekly.vue'
    import monthly from './schedule/Monthly.vue'
    import yearly from './schedule/Yearly.vue'

    export default {

        name: 'Schedule',

        props: [ 'model' ],

        mixins: [ RouterHelpers ],

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
                weekly_day_num: [],
                myform: [],
                advancedMode: false
            };
        },

        methods: {

            toggleMode() {
                this.advancedMode = !this.advancedMode;
            },

            attemptUpdateSchedule() {

                if (this.myform.$valid)
                    this.updateSchedule();

            },

            flipDates(date) {

                if (!date)
                    return date;

                var converted_date = date.split('-');

                if (date.length==10)
                    return converted_date[2]+'-'+converted_date[1]+'-'+converted_date[0].substring(2);

                else if (date.length==8)
                    return '20'+converted_date[2]+'-'+converted_date[1]+'-'+converted_date[0];

                else
                    return date;

            },

            updateSchedule() {

                this.encodeModel();

                var self = this;

                client({ path: '/'+self.model.type+'s/'+self.model.id, entity: self.model, method: 'PUT'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans(self.model.type + '.updated'),
                            options: {theme: 'success'}
                        })

                        self.goBack();

                    },

                    function (response) {
                        
                        self.$dispatch('alert', {
                            message: self.trans('screen.updated_fail'),
                            options: {theme: 'error'}
                        });
                        
                    }

                );

            },

            encodeModel() {

                this.event.start_date = this.flipDates(this.event.start_date);
                this.event.end_date = this.flipDates(this.event.end_date);
                this.event.weekly_day_num = JSON.stringify(this.weekly_day_num);
                this.model.screengroups = this.selected_screengroups;

            },

            decodeModel() {

                this.event.start_date = this.flipDates(this.event.start_date);
                this.event.end_date = this.flipDates(this.event.end_date);

                if (this.model.screengroups != null || this.model.screengroups != [] || this.model.screengroups != "") {
                    
                    var self = this;

                    this.model.screengroups.forEach(function(entry) {
                        self.selected_screengroups.push(entry.id)
                    });

                }

                this.weekly_day_num = JSON.parse(this.event.weekly_day_num);

            }

        },

        computed: {

            summary() {
                return 'summary_text';
            },

            event() {
                return this.model.event;
            },

            get_start_time() {
                return this.model.event.start_time;
            }

        },

        ready: function() {
            this.decodeModel();
        },

    };
</script>
