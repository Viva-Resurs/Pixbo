<template>
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">
                {{ trans('schedule.frequency') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_frequency_week_tooltip') }}"></span>
            </label>
            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label class="control-label">
                {{ trans('schedule.weekdays') }}
                <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('schedule.event_frequency_week_tooltip') }}"></span>
            </label>

            <br>
            <label v-for="day in weekdays">
                {{ trans(day) }}
                <input v-model="weekly_day_num" type="checkbox" value="$index+1">
            </label>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['event'],
        data() {
            return {
                weekdays: [
                    'messages.monday_short',
                    'messages.tuesday_short',
                    'messages.wednesday_short',
                    'messages.thursday_short',
                    'messages.friday_short',
                    'messages.saturday_short',
                    'messages.sunday_short',
                ],
                weekly_day_num: null,
            }
        },
        created() {
            this.weekly_day_num = this.event.recur_day_num;
        }
    }
</script>