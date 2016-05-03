<template>
    <form v-on:submit.prevent="send_post">
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
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('screengroup.tooltip') }}"></span>
            </legend>
            <div class="form-group">
                <select class="form-control" multiple v-model="selected_screengroups" id="inputScreengroups">
                    <option v-for="screengroup in screengroups" v-bind:value="screengroup.id">{{screengroup.name}}</option>
                </select>
            </div>

            <template v-if="model.type == 'screen'">
                <Tagger :list.sync="selected_tags" :tags.sync="tags"></Tagger>
            </template>


            <legend>{{ trans('schedule.period') }}</legend>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-6 col-md-6">
                        <label for="inputStart_date" class="control-label">
                            {{ trans('schedule.start') }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.start_date_tooltip') }}"></span>
                        </label>
                        <div class="">
                            <input v-model="model.event.start_date" type="date" name="start_date" id="inputStart_date" class="form-control" required="required" title="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label for="inputEnd_date" class="control-label">
                            {{ trans('schedule.end') }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.end_date_tooltip') }}"></span>
                        </label>
                        <div class="">
                            <input type="date" v-model="model.event.end_date" name="end_date" id="inputEnd_date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-6 col-md-6">
                        <label for="inputStart_time" class="control-label">
                            {{ trans('schedule.start') }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.start_time_tooltip') }}"></span>
                        </label>
                        <div class="">
                            <input type="time" v-model="model.event.start_time" name="start_time" id="inputStart_time" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label for="inputEnd_time" class="control-label">
                            {{ trans('schedule.end') }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_end_time_tooltip') }}"></span>
                        </label>
                        <div class="">
                            <input type="time" v-model="model.event.end_time" name="end_time" id="inputEnd_time" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-md-6">

            <legend>{{ trans('schedule.recurring') }}</legend>

            <label for="inputRecur_type" class="control-label">
                {{ trans('schedule.repeat') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_repeat_type_tooltip') }}"></span>
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
                <schedule-weekly :weekly_day_num.sync="weekly_day_num" :frequency.sync="event.frequency"></schedule-weekly>
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

        <button type="submit" id="submitButton_{{ id }}" class="btn btn-default">{{ trans('general.save') }}</button>

    </form>
</template>

<script>
    import Tag from './../components/Tag.vue';

    export default {

        props: ['model', 'redirect', 'tags', 'screengroups'],

        components: {
            ScheduleDaily: require('./schedule/Daily.vue'),
            ScheduleWeekly: require('./schedule/Weekly.vue'),
            ScheduleMonthly: require('./schedule/Monthly.vue'),
            ScheduleYearly: require('./schedule/Yearly.vue'),
            Tagger: require('./Tag.vue'),
            DateTimePicker: require('./DateTimePicker.vue')
        },

        data: function() {
            return {
                weekly_day_num: [],
                monthly_day_num: '',
                error: {
                    missing_tag: 'messages.tag_missing'
                },
                recur_options: [
                    {key: null, value: 'schedule.never'},
                    {key: 'daily', value: 'schedule.daily'},
                    {key: 'weekly', value: 'schedule.weekly'},
                    {key: 'monthly', value: 'schedule.monthly'},
                    {key: 'yearly', value: 'schedule.yearly'}
                ]
            };
        },

        methods: {
            send_post: function() {

                if(this.isValid) {

                    var day_num = null;
                    var recur = this.event.recur_type;

                    switch (recur) {
                        case "weekly":
                            day_num = this.weekly_day_num;
                            break;
                        case "monthly":
                            day_num = this.monthly_day_num;
                            break;
                        default:
                            day_num = '';
                            break;
                    }
                    var payload = {
                        event: this.event,
                        selected_screengroups: this.selected_screengroups,
                        selected_tags: this.selected_tags,
                        day_num: day_num,
                        modelObject: this.modelObject,
                    };
                    this.send_ajax(payload);
                } else {

                }

            },

            send_ajax: function(payload) {
                var vm = this;
                console.log(vm.modelObject);
                this.$http.put('/admin/' + vm.model + '/' + vm.modelObject.id, payload).then(function (response) {
                    if(response.ok) {
                        vm.close_modal();
                    }
                    if(response) {
                        vm.$dispatch('add-alert', response.data);
                    }

                });
            },

            parse_event: function() {
                if(this.event.recur_day_num == null) {
                    this.weekly_day_num = [];
                    this.monthly_day_num = '1';
                } else {
                    var parsed_week = JSON.parse(this.event.recur_day_num);
                    if(typeof parsed_week == 'string' || parsed_week == null)
                        this.weekly_day_num = [];
                    else
                        this.weekly_day_num = parsed_week;
                    this.monthly_day_num = JSON.parse(this.event.recur_day_num);
                }

                if(this.event.recur_day == null)
                    this.event.recur_day = '1';

                if(this.monthly_day_num.length > 1 || this.monthly_day_num == "")
                    this.monthly_day_num = '1';


            },
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
            selected_screengroups() {
                return this.model.screengroups;
            },

            isValid: function() {
                if(this.model.type == 'screens') {
                    if (this.selected_tags.length > 0) {
                        return true;
                    } else {
                        $('#inputTags').focus();
                        return false;
                    }
                } else return true;
            },
            get_start_time() {
                return this.model.event.start_time;
            }
        },
        created: function () {
        },
    };
</script>