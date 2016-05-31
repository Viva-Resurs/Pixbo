/**
* Created by Christoffer Isenberg on 19-May-16.
*/

<template>

    <div class="row">
    
        <div class="col-lg-6 col-md-6">
            <label for="inputStart_date" class="schedule_label">
                {{ trans('schedule.start_date') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_start_date') }}"></span>
            </label>
            <div class="input-group date">
                <input v-model="event.start_date" type="text" name="start_date" id="inputStart_date" class="form-control" required="required" title="">
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <label for="inputEnd_date" class="schedule_label">
                {{ trans('schedule.end_date') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_end_date') }}"></span>
            </label>
            <div class="input-group date">
                <input v-model="event.end_date" type="text" name="start_date" id="inputEnd_date" class="form-control">
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
            </div>
        </div>
    
    </div>
    <div class="row">

        <div class="col-lg-6 col-md-6">
            <label for="inputStart_time" class="schedule_label">
                {{ trans('schedule.start_time') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_start_time') }}"></span>
            </label>
            <div class="input-group time">
                <input v-model="event.start_time" type="text" name="start_time" id="inputStart_time" required="required" class="form-control">
                <span class="input-group-addon">
                    <span class="fa fa-clock-o"></span>
                </span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <label for="inputEnd_time" class="schedule_label">
                {{ trans('schedule.end_time') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_end_time') }}"></span>
            </label>
            <div class="input-group time">
                <input v-model="event.end_time" type="text" name="end_time" id="inputEnd_time" required="required" class="form-control">
                <span class="input-group-addon">
                    <span class="fa fa-clock-o"></span>
                </span>
            </div>
        </div>
    
    </div>

</template>

<script type="text/ecmascript-6">
    export default {
        props: ['event'],
        ready(){
            $(function () {
                $('.date').datetimepicker({
                    format: "DD-MM-YY",
                    icons: {
                        time: 'fa fa-clock-o',
                        date: 'fa fa-calendar',
                        up: 'fa fa-chevron-up',
                        down: 'fa fa-chevron-down',
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                    }
                })
            });
            $(function () {
                $('.time').datetimepicker({
                    format: "HH:mm",
                    icons: {
                        time: 'fa fa-clock-o',
                        date: 'fa fa-calendar',
                        up: 'fa fa-chevron-up',
                        down: 'fa fa-chevron-down',
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                    }
                })
            });
        }
    }
</script>