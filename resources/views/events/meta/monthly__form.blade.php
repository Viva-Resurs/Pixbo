<div class="monthly" style="display: none;">

   <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <input type="number" name="monthly_frequency" id="monthly_frequency" value="1" min="1" max="31" step="1" required="required">
            {{ trans('messages.months') }}
        </div>
    </div>

    <div class="col-md-4">
        {{ trans('messages.the') }}
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-3">
                <select name="recur_monthly_week" id="inputRecur_monthly_week" class="form-group selectpicker" required="required">
                    <option value="first">{{ trans('messages.first') }}</option>
                    <option value="second">{{ trans('messages.second') }}</option>
                    <option value="third">{{ trans('messages.third') }}</option>
                    <option value="fourth">{{ trans('messages.fourth') }}</option>
                    <option value="last">{{ trans('messages.last') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="recur_monthly_week_day" id="inputRecur_monthly_week_day" class="form-group selectpicker" required="required">
                    <option value="0">{{ trans('messages.monday') }}</option>
                    <option value="1">{{ trans('messages.tuesday') }}</option>
                    <option value="2">{{ trans('messages.wednesday') }}</option>
                    <option value="3">{{ trans('messages.thursday') }}</option>
                    <option value="4">{{ trans('messages.friday') }}</option>
                    <option value="5">{{ trans('messages.saturday') }}</option>
                    <option value="6">{{ trans('messages.sunday') }}</option>
                </select>
            </div>
            <div class="col-md-6">
                {{ trans('messages.each_month') }}
            </div>
        </div>
    </div>
</div>

<hr/>