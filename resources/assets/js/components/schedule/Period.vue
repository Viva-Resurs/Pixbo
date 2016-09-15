<template>

    <div class="row">
    
        <div class="col-lg-6 col-md-6">
            <label for="inputStart_date" class="schedule_label">
                {{ trans('schedule.start_date') }}
                <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_start_date') }}"></span>
            </label>
            <div class="input-group date">
                <input v-model="event.start_date" type="text" name="start_date" id="inputStart_date" class="form-control" required title="">
                <span class="input-group-addon btn btn-default">
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
                <span class="input-group-addon btn btn-default">
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
                <input v-model="event.start_time" type="text" name="start_time" id="inputStart_time" required class="form-control">
                <span class="input-group-addon btn btn-default">
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
                <input v-model="event.end_time" type="text" name="end_time" id="inputEnd_time" required class="form-control">
                <span class="input-group-addon btn btn-default">
                    <span class="fa fa-clock-o"></span>
                </span>
            </div>
        </div>
    
    </div>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'Period',

        props: [ 'event' ],

        ready: function() {

            var options = {
                showTodayButton: true,
                toolbarPlacement: 'top',
                calendarWeeks: true,
                showClose: true,
                allowInputToggle: true,
                minDate: moment().hour(0).minute(0).subtract(1,'d'),
                maxDate: moment().hour(0).minute(0).add(5,'y'),
                locale: moment.locale('sv'),
                tooltips: {
                    today: this.trans('dateTimePicker.today'),
                    clear: this.trans('dateTimePicker.clear'),
                    close: this.trans('dateTimePicker.close'),
                    selectMonth: this.trans('dateTimePicker.selectMonth'),
                    prevMonth: this.trans('dateTimePicker.prevMonth'),
                    nextMonth: this.trans('dateTimePicker.nextMonth'),
                    selectYear: this.trans('dateTimePicker.selectYear'),
                    prevYear: this.trans('dateTimePicker.prevYear'),
                    nextYear: this.trans('dateTimePicker.nextYear'),
                    selectDecade: this.trans('dateTimePicker.selectDecade'),
                    prevDecade: this.trans('dateTimePicker.prevDecade'),
                    nextDecade: this.trans('dateTimePicker.nextDecade'),
                    prevCentury: this.trans('dateTimePicker.prevCentury'),
                    nextCentury: this.trans('dateTimePicker.nextCentury'),
                    incrementHour: this.trans('dateTimePicker.incrementHour'),
                    decrementHour: this.trans('dateTimePicker.decrementHour'),
                    incrementMinute: this.trans('dateTimePicker.incrementMinute'),
                    decrementMinute: this.trans('dateTimePicker.decrementMinute'),
                    pickMinute: this.trans('dateTimePicker.pickMinute'),
                    pickHour: this.trans('dateTimePicker.pickHour')
                },
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-crosshairs',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            };

            options.format = "YYYY-MM-DD";

            $('.date').datetimepicker(options);

            options.format = "HH:mm";
            options.showTodayButton = false;
            options.showClose = false;

            $('.time').datetimepicker(options);

        }

    }
</script>
