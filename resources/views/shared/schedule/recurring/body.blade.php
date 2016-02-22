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
@include('shared.schedule.recurring.daily')

<!-- Weekly -->
@include('shared.schedule.recurring.weekly')

<!-- Monthly -->
@include('shared.schedule.recurring.monthly')

<!-- Yearly -->
@include('shared.schedule.recurring.yearly')

<!-- Summary -->
@include('shared.schedule.recurring.summary')