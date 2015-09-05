<div class="weekly" style="display: none;">

    <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <input type="number" name="frequency" id="inputFrequency" value="1" min="1" max="31" step="1" required="required">
            {{ trans('messages.weeks') }}
        </div>
    </div>

    <div class="col-md-4">
        {{ trans('messages.repeat_each') }}
    </div>
    <div class="col-md-8">
        @include('events.meta.days__form')
    </div>

</div>