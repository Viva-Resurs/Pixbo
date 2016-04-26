<template>
    <form>

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
                {{ 'messages.screen_group' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.screengroup_tooltip' }}"></span>
            </legend>
            <div class="form-group">
                <select class="form-control" multiple v-model="selected_screengroups" id="inputScreengroups">
                    <option v-for="screengroup in screengroups" v-bind:value="screengroup.value">{{screengroup.text}}</option>
                </select>
            </div>

            <template v-if="model.type == 'screen'">
                <Tagger :list.sync="selected_tags"></Tagger>
            </template>


            <legend>{{ 'messages.period' }}</legend>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-6 col-md-6">
                        <label for="inputStart_date" class="control-label">
                            {{ 'messages.start' }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_start_date_tooltip' }}"></span>
                        </label>
                        <div class="">
                            <input v-model="model.event.start_date" type="date" name="start_date" id="inputStart_date" class="form-control" required="required" title="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label for="inputEnd_date" class="control-label">
                            {{ 'messages.end' }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_end_date_tooltip' }}"></span>
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
                            {{ 'messages.start' }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_start_time_tooltip' }}"></span>
                        </label>
                        <div class="">
                            <input type="time" v-model="model.event.start_time" name="start_time" id="inputStart_time" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label for="inputEnd_time" class="control-label">
                            {{ 'messages.end' }}
                            <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_end_time_tooltip' }}"></span>
                        </label>
                        <div class="">
                            <input type="time" v-model="model.event.end_time" name="end_time" id="inputEnd_time" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-md-6">

            <legend>{{ 'messages.recurring' }}</legend>

            <label for="inputRecur_type" class="control-label">
                {{ 'messages.repeat' }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.event_repeat_type_tooltip' }}"></span>
            </label>
            <select v-model="event.recur_type" v-bind:value="event.recur_type" name="recur_type" id="inputRecur_type" class="form-control">
                <option value="">       {{ 'messages.never'  }}</option>
                <option value="daily">  {{ 'messages.daily'   }}</option>
                <option value="weekly"> {{ 'messages.weekly'  }}</option>
                <option value="monthly">{{ 'messages.monthly' }}</option>
                <option value="yearly"> {{ 'messages.yearly'  }}</option>
            </select>

            <!-- Daily -->
            <template v-if="event.recur_type == 'daily'">
                <schedule-daily></schedule-daily>
            </template>

            <!-- Weekly -->
            <template v-if="event.recur_type == 'weekly'">
                <schedule-weekly></schedule-weekly>
            </template>

            <!-- Monthly -->
            <template v-if="event.recur_type == 'monthly'">
                <schedule-monthly></schedule-monthly>
            </template>

            <!-- Yearly -->
            <template v-if="event.recur_type == 'yearly'">
                <schedule-yearly></schedule-yearly>
            </template>

            <!-- Summary -->
            <div class="row"></div>
            <label>{{ 'messages.summary' }}</label> {{ summary }}

        </div>

        <button type="submit" id="submitButton_{{ id }}" class="" style="display: none;">{{ 'messages.save' }}</button>

    </form>
</template>

<script>
    import Tag from './../components/Tag.vue';

    export default {

        props: ['model', 'redirect'],

        components: {
            ScheduleDaily: require('./schedule/Daily.vue'),
            ScheduleWeekly: require('./schedule/Weekly.vue'),
            ScheduleMonthly: require('./schedule/Monthly.vue'),
            ScheduleYearly: require('./schedule/Yearly.vue'),
            Tagger: require('./Tag.vue')
        },

        data: function() {
            return {
                screengroups: [],
                event: {},
                selected_screengroups: [],
                selected_tags: '',
                tags: [],
                weekly_day_num: [],
                monthly_day_num: '',
                error: {
                    missing_tag: 'messages.tag_missing'
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
        },

        computed: {
            summary: function() {
                return 'summary_text';
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
            }
        },
        ready: function () {
            /*
            this.get_all_screengroups();
            if(this.model == 'screens')
                this.get_all_tags();
            this.get_model();
            */
        },
    };
</script>