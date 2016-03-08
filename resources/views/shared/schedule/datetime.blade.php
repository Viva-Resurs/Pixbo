<legend>{{ trans('messages.period') }}</legend>
<div class="row">
    <div class="form-group">
        <div class="col-lg-6 col-md-6">
            <label for="inputStart_date" class="control-label">
                {{ trans('messages.start') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_start_date_tooltip') }}"></span>
            </label>
            <div class="">
                <input v-model="event.start_date" type="date" name="start_date" id="inputStart_date" class="form-control" v-bind:value="event.start_date" required="required" title="">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <label for="inputEnd_date" class="control-label">
                {{ trans('messages.end') }}
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.event_end_date_tooltip') }}"></span>
            </label>
            <div class="">
                <input type="date" v-model="event.end_date" v-bind:value="event.end_date" name="end_date" id="inputEnd_date" class="form-control" value="" title="">
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