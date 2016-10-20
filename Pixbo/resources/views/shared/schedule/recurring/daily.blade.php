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