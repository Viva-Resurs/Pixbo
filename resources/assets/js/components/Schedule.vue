<template>
    <form v-on:submit.prevent="updateSchedule">
        <template v-if="model.type == 'ticker'">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="text" v-model="model.text" name="ticker_text" id="inputTickerText" class="form-control" title="" required="required">
                    </div>
                </div>
            </div>
        </template>

        <div class="col-lg-6 col-md-6">
            <legend>
                {{ trans_choice('screengroup.model', 1) }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_screengroup') }}"></span>
            </legend>
            <div class="form-group">
                <select class="form-control" multiple v-model="selected_screengroups" id="inputScreengroups">
                    <option v-for="screengroup in screengroups" v-bind:value="screengroup.id">{{screengroup.name}}</option>
                </select>
            </div>

            <!--
            <template v-if="model.type == 'screen'">
                <Tagger :list.sync="selected_tags" :tags.sync="tags"></Tagger>
            </template>
            -->

            <period :event.sync="model.event"></period>

        </div>

        <div class="col-lg-6 col-md-6">

            <legend>{{ trans('schedule.recurring') }}</legend>

            <label for="inputRecur_type" class="control-label">
                {{ trans('schedule.repeat') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_repeat_type') }}"></span>
            </label>
            <select v-model="event.recur_type" v-bind:value="event.recur_type" name="recur_type" id="inputRecur_type" class="form-control">
                <option v-for="option in recur_options" :value="option.key">{{ trans(option.value) }}</option>

            </select>

            <!-- Daily -->
            <template v-if="event.recur_type == 'daily'">
                <schedule-daily :frequency.sync="event.frequency"></schedule-daily>
            </template>

            <!-- Weekly -->
            <template v-if="event.recur_type == 'weekly'">
                <schedule-weekly
                        :day_num.sync="weekly_day_num"
                        :frequency.sync="event.frequency"
                ></schedule-weekly>
            </template>

            <!-- Monthly -->
            <template v-if="event.recur_type == 'monthly'">
                <schedule-monthly
                        :monthly_day_num.sync="monthly_day_num"
                        :frequency.sync="event.frequency"
                        :days_before_event.sync="event.days_before_event"
                        :recur_day.sync="event.recur_day"
                ></schedule-monthly>
            </template>

            <!-- Yearly -->
            <template v-if="event.recur_type == 'yearly'">
                <schedule-yearly :frequency.sync="event.frequency"></schedule-yearly>
            </template>

            <!-- Summary -->
            <div class="row"></div>
            <label>{{ trans('general.summary') }}</label> {{ summary }}

        </div>

            <button type="" class="btn" @click="goBack">
              <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
            </button>
            <button type="submit" class="btn btn-primary" :disabled="isValid" id="submitButton_{{ id }}">
                <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
            </button>

    </form>
</template>

<script>
    import Tag from './../components/Tag.vue';
    import Period from './schedule/Period.vue';

    export default {

        props: ['model', 'redirect', 'tags', 'screengroups', 'messages'],

        components: {
            ScheduleDaily: require('./schedule/Daily.vue'),
            ScheduleWeekly: require('./schedule/Weekly.vue'),
            ScheduleMonthly: require('./schedule/Monthly.vue'),
            ScheduleYearly: require('./schedule/Yearly.vue'),
            //Tagger: require('./Tag.vue'),
            DateTimePicker: require('./DateTimePicker.vue'),
            Period
        },

        data: function() {
            return {

                selected_screengroups: [],
                weekly_day_num: [],
                monthly_day_num: '',
                recur_options: [
                    {key: 'none', value: 'schedule.never'},
                    {key: 'daily', value: 'schedule.daily'},
                    {key: 'weekly', value: 'schedule.weekly'},
                    {key: 'monthly', value: 'schedule.monthly'},
                    {key: 'yearly', value: 'schedule.yearly'}
                ]
            };
        },

        methods: {

            updateSchedule: function () {
                // Update model stuff
                this.encodeModel();

                var self = this
                client({ path: `/${self.model.type}s/${self.model.id}`, entity: self.model, method: 'PUT'}).then(
                        function (response) {
                            console.log("updated!")
                            // Show alert success
                        },
                        function (response) {
                            // Show alert error
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
            selected_tags() {
                return this.model.tags;
            },

            isValid: function() {
                if(this.model.type == 'screen') {
                    if (this.selected_tags.length > 0) {
                        return true;
                    } else {
                        $('#inputTags').focus();
                        return false;
                    }
                } else {
                    if(this.model.type == 'ticker')
                        return true;
                    else return false
                }
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