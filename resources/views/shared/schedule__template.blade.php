<template id="schedule-template">
    <form id="screenform" action="" method="POST" role="form" v-on:submit.prevent="send_post">
        {{ csrf_field () }}

        <template v-if="model == 'screen'">
            <legend>
                {{ trans('messages.tags') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.tag_tooltip') }}"></span>
            </legend>
            <div class="form-group">
                <div class="">
                    <input type="text" v-model="selected_tags" v-bind:value="tagged" name="tags" id="inputTags" class="form-control" required="required" placeholder="tag tag">
                </div>
            </div>
        </template>
        <template v-if="model == 'ticker'">
        <legend>{{ trans('messages.ticker') }}</legend>
            <div class="form-group">
                <label for="inputText" class="col-sm-2 control-label">Text:</label>
                <div class="col-sm-10">
                    <input v-model="modelObject.text" type="text" name="text" id="inputText" class="form-control" required="required" title="">
                </div>
            </div>
        </template>

        <legend>
            {{ trans('messages.screen_group') }}
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.screengroup_tooltip') }}"></span>
        </legend>
        <select class="form-control" multiple v-model="selected_screengroups" id="inputScreengroups">
            <option v-for="screengroup in screengroups" v-bind:value="screengroup.value">@{{screengroup.text}}</option>
        </select>

        <legend>{{ trans('messages.schedule') }}</legend>
        <div class="col-md-12">
            <div class="form-group">
                <label for="inputStart_date" class="control-label">
                    {{ trans('messages.start_date') }}
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_start_date_tooltip') }}"></span>
                </label>
                <div class="">
                    <input v-model="event.start_date" type="date" name="start_date" id="inputStart_date" class="form-control" v-bind:value="event.start_date" required="required" title="">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEnd_date" class="control-label">
                    {{ trans('messages.end_date') }}
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_end_date_tooltip') }}"></span>
                </label>
                <div class="">
                    <input type="date" v-model="event.end_date" v-bind:value="event.end_date" name="end_date" id="inputEnd_date" class="form-control" value="" title="">
                </div>
            </div>

            <div class="form-group">
                <label for="inputStart_time" class="control-label">
                    {{ trans('messages.start_time') }}
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_start_time_tooltip') }}"></span>
                </label>
                <div class="">
                    <input type="time" v-model="event.start_time" name="start_time" id="inputStart_time" class="form-control" value="" title="">
                </div>
            </div>

             <div class="form-group">
                <label for="inputEnd_time" class="control-label">
                    {{ trans('messages.end_time') }}
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_end_time_tooltip') }}"></span>
                </label>
                <div class="">
                    <input type="time" v-model="event.end_time" name="end_time" id="inputEnd_time" class="form-control" value="" title="">
                </div>
            </div>

            <label for="inputRecur_type" class="control-label">
                {{ trans('messages.repeat') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_repeat_type_tooltip') }}"></span>
            </label>
            <select v-model="event.recur_type" v-bind:value="event.recur_type" name="recur_type" id="inputRecur_type" class="form-control">
                <option value=""> {{ trans('messages.never') }}</option>
                <option value="daily">{{ trans('messages.daily') }}</option>
                <option value="weekly">{{ trans('messages.weekly') }}</option>
                <option value="monthly">{{ trans('messages.monthly') }}</option>
                <option value="yearly">{{ trans('messages.yearly') }}</option>
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
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_week_tooltip') }}"></span>
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
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_day_tooltip') }}"></span>
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
            <div class="row"></div>
            <label>{{ trans('messages.summary') }}</label> @{{ summary }}
        </div>

        <button type="submit" class="btn btn-primary">{{ trans('messages.save') }}</button>
    </form>
</template>
