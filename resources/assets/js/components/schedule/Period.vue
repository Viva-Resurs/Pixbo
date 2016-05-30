/**
* Created by Christoffer Isenberg on 19-May-16.
*/

<template>
    <div class="row">
        <div>
            <div class="col-lg-6 col-md-6">
                <label for="inputStart_date" class="control-label">
                    {{ trans('schedule.start_date') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_start_date') }}"></span>
                </label>
                <div class="">
                    <input v-model="event.start_date" type="date" name="start_date" id="inputStart_date" class="form-control" required="required" title="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="inputEnd_date" class="control-label">
                    {{ trans('schedule.end_date') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_end_date') }}"></span>
                </label>
                <div class="">
                    <input type="date" v-model="event.end_date" name="end_date" id="inputEnd_date" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div>
            <div class="col-lg-6 col-md-6">
                <label for="inputStart_time" class="control-label">
                    {{ trans('schedule.start_time') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_start_time') }}"></span>
                </label>
                <div class="">
                    <input type="time" v-model="event.start_time" name="start_time" id="inputStart_time" class="form-control">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="inputEnd_time" class="control-label">
                    {{ trans('schedule.end_time') }}
                    <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_event_end_time') }}"></span>
                </label>
                <div class="">
                    <input type="time" v-model="event.end_time" name="end_time" id="inputEnd_time" class="form-control">
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        props: ['event']
    }
</script>

<style>

</style>