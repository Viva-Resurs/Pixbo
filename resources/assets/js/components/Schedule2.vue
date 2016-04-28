<template>
        <form :id="'schedule_form_' + model + '_' + id" :action="'/admin/' + model + '/' + id" method="PATCH" role="form" v-on:submit.prevent="send_post">

            <template v-if="model == 'tickers'">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <input type="text" v-model="modelObject.text" name="ticker_text" id="inputTickerText" class="form-control" title="" required="required">
                        </div>
                    </div>
                </div>
            </template>

            <div class="col-lg-6 col-md-6">

                <legend>
                    {{ trans_choice('messages.screen_group',1) }}
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.screengroup_tooltip') }}"></span>
                </legend>
                <div class="form-group">
                    <select class="form-control" multiple v-model="selected_screengroups" id="inputScreengroups">
                        <option v-for="screengroup in screengroups" v-bind:value="screengroup.value">{{screengroup.text}}</option>
                    </select>
                </div>

                <template v-if="model == 'screens'">
                    <Tagger :list.sync="selected_tags"></Tagger>
                </template>


                <legend>{{ trans('messages.period') }}</legend>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6">
                            <label for="inputStart_date" class="control-label">
                                {{ trans('messages.start') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_start_date_tooltip') }}"></span>
                            </label>
                            <div class="input-group date">
                                <input v-model="event.start_date" type="text" name="start_date" id="inputStart_date" class="form-control" v-bind:value="event.start_date" required="required" title="">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label for="inputEnd_date" class="control-label">
                                {{ trans('messages.end') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_end_date_tooltip') }}"></span>
                            </label>
                            <div class="input-group date">
                                <input type="date" v-model="event.end_date" v-bind:value="event.end_date" name="end_date" id="inputEnd_date" class="form-control" value="" title="">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6">
                            <label for="inputStart_time" class="control-label">
                                {{ trans('messages.start') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_start_time_tooltip') }}"></span>
                            </label>
                            <div class="">
                                <input type="time" v-model="event.start_time" name="start_time" id="inputStart_time" class="form-control" value="" title="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label for="inputEnd_time" class="control-label">
                                {{ trans('messages.end') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_end_time_tooltip') }}"></span>
                            </label>
                            <div class="">
                                <input type="time" v-model="event.end_time" name="end_time" id="inputEnd_time" class="form-control" value="" title="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-6">

                <legend>{{ trans('messages.recurring') }}</legend>

                <label for="inputRecur_type" class="control-label">
                    {{ trans('messages.repeat') }}
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_repeat_type_tooltip') }}"></span>
                </label>
                <select v-model="event.recur_type" v-bind:value="event.recur_type" name="recur_type" id="inputRecur_type" class="form-control">
                    <option value="">       {{ trans('messages.never')   }}</option>
                    <option value="daily">  {{ trans('messages.daily')   }}</option>
                    <option value="weekly"> {{ trans('messages.weekly')  }}</option>
                    <option value="monthly">{{ trans('messages.monthly') }}</option>
                    <option value="yearly"> {{ trans('messages.yearly')  }}</option>
                </select>

                <!-- Daily -->
                <template v-if="event.recur_type == 'daily'">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputFrequency" class="control-label">
                                {{ trans('messages.frequency') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_day_tooltip') }}"></span>
                            </label>
                            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
                        </div>
                    </div>
                </template>

                <!-- Weekly -->
                <template v-if="event.recur_type == 'weekly'">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputFrequency" class="control-label">
                                {{ trans('messages.frequency') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_week_tooltip') }}"></span>
                            </label>
                            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label">
                                {{ trans('messages.weekdays') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_week_tooltip') }}"></span>
                            </label>

                            <br>
                            <label>
                                {{ trans('messages.monday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="1">
                            </label>
                            <label>
                                {{ trans('messages.tuesday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="2">
                            </label>
                            <label>
                                {{ trans('messages.wednesday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="3">
                            </label>
                            <label>
                                {{ trans('messages.thursday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="4">
                            </label>
                            <label>
                                {{ trans('messages.friday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="5">
                            </label>
                            <label>
                                {{ trans('messages.saturday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="6">
                            </label>
                            <label>
                                {{ trans('messages.sunday_short') }}
                                <input v-model="weekly_day_num" type="checkbox" value="0">
                            </label>
                        </div>
                    </div>
                </template>

                <!-- Monthly -->
                <template v-if="event.recur_type == 'monthly'">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputFrequency" class="control-label">
                                {{ trans('messages.frequency') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_frequency_month_tooltip') }}"></span>
                            </label>
                            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputRecur_day_num">
                                {{ trans('messages.week') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_week_tooltip' }}"></span>
                            </label>
                            <select v-model="monthly_day_num" value="1" name="recur_day_num" id="inputRecur_day_num" class="form-control">
                                <option value="1">{{ trans('messages.first') }}</option>
                                <option value="2">{{ trans('messages.second') }}</option>
                                <option value="3">{{ trans('messages.third') }}</option>
                                <option value="4">{{ trans('messages.fourth') }}</option>
                                <option value="5">{{ trans('messages.last') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputRecur_day">
                                {{ trans('messages.day') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_day_tooltip' }}"></span>
                            </label>
                            <select v-model="event.recur_day" name="recur_day" id="inputRecur_day" class="form-control">
                                <option value="1">{{ trans('messages.monday') }}</option>
                                <option value="2">{{ trans('messages.tuesday') }}</option>
                                <option value="3">{{ trans('messages.wednesday') }}</option>
                                <option value="4">{{ trans('messages.thursday') }}</option>
                                <option value="5">{{ trans('messages.friday') }}</option>
                                <option value="6">{{ trans('messages.saturday') }}</option>
                                <option value="0">{{ trans('messages.sunday') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputDays_before" class="control-label">
                                {{ trans('messages.days_before_event') }}
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_days_ahead_tooltip') }}"></span>
                            </label>
                            <input v-model="event.days_before_event" type="number" name="days_before" id="inputDays_before" class="form-control" v-bind:value="event.days_before_event" min='0' max='30' step='1' title="">
                        </div>
                    </div>
                </template>

                <!-- Yearly -->
                <template v-if="event.recur_type == 'yearly'">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputFrequency" class="control-label">{{ trans('messages.year_frequency') }}</label>
                            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
                        </div>
                    </div>
                </template>

                <!-- Summary -->
                <div class="row"></div>
                <label>{{ trans('messages.summary') }}</label> {{ trans(summary) }}

            </div>

            <button type="submit" id="submitButton_{{ id }}" class="" style="display: none;">{{ trans('messages.save') }}</button>

            <Datetimepicker></Datetimepicker>
            <Tooltips></Tooltips>
        </form>
</template>

<script>
    import Tags from './Tags.vue';
    import DateTimePicker from './DateTimePicker.vue';
    import Tooltips from './Tooltip.vue';

    export default {

        props: ['id', 'model'],

        components: {
            'Tagger': Tags,
            'Datetimepicker' : DateTimePicker,
            'Tooltips' : Tooltips,
        },

        data: function() {
            return {
                screengroups: [],
                modelObject: {},
                event: {},
                selected_screengroups: [],
                selected_tags: '',
                tags: [],
                weekly_day_num: [],
                monthly_day_num: '',
                error: {
                    missing_tag: this.trans('messages.tag_missing') ,
                }
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

            get_all_screengroups: function() {
                this.$http.get('/api/screengroups', function(screengroups) {
                    this.screengroups = screengroups;
                }.bind(this));
            },
            get_all_tags: function() {
                this.$http.get('/api/tags', function(tags) {
                    this.tags = tags;
                }.bind(this));
            },
            get_model: function() {
                this.$http.get('/api/' + this.model + '/' + this.id, function(modelObject) {
                    this.modelObject = modelObject;
                    if (modelObject.event)
                      this.event = modelObject.event.pop();
                    if(this.model == 'screens')
                        this.selected_tags = modelObject.tags;
                    this.parse_event();
                    this.set_selected_screengroups();
                }.bind(this));
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

            set_selected_screengroups: function() {
                var sgs = this.modelObject.screengroups != null ? this.modelObject.screengroups.length : 0;
                for (var i =0;i<sgs;i++) {
                    this.selected_screengroups.push(this.modelObject.screengroups[i].id);
                }
            },

            close_modal: function() {
                var modal = '#' + this.model + '_modal_' + this.modelObject.id;
                console.log(modal);
                $(modal).modal('hide');
            }
        },

        computed: {
            summary: function() {
                return 'summary_text';
            },

            isValid: function() {
                if(this.model == 'screens') {
                    if (this.selected_tags.length > 0) {
                        return true;
                    } else {
                        $('#inputTags').focus();
                        return false;
                    }
                } else return true;
            }
        },

        ready: function () {
            this.get_all_screengroups();
            if(this.model == 'screens')
                this.get_all_tags();
            this.get_model();
        },
    };
</script>