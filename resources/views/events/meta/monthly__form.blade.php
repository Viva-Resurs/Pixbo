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
                <select name="monthly_recur_day_num" id="monthly_recur_day_num" class="form-group selectpicker" required="required">
                    <option value="1">{{ trans('messages.first') }}</option>
                    <option value="2">{{ trans('messages.second') }}</option>
                    <option value="3">{{ trans('messages.third') }}</option>
                    <option value="4">{{ trans('messages.fourth') }}</option>
                    <option value="5">{{ trans('messages.last') }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="monthly_recur_day" id="monthly_recur_day" class="form-group selectpicker" required="required">
                    <option value="1">{{ trans('messages.monday') }}</option>
                    <option value="2">{{ trans('messages.tuesday') }}</option>
                    <option value="3">{{ trans('messages.wednesday') }}</option>
                    <option value="4">{{ trans('messages.thursday') }}</option>
                    <option value="5">{{ trans('messages.friday') }}</option>
                    <option value="6">{{ trans('messages.saturday') }}</option>
                    <option value="0">{{ trans('messages.sunday') }}</option>
                </select>
            </div>
            <div class="col-md-5">
                {{ trans('messages.each_month') }}
            </div>
        </div>
    </div>
</div>

<hr/>