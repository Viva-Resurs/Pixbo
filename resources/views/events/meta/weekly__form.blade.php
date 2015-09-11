<div class="weekly" style="display: none;">

    <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <input type="number" name="weekly_frequency" id="weekly_frequency" value="1" min="1" max="31" step="1" required="required">
            {{ trans('messages.weeks') }}
        </div>
    </div>

    <div class="col-md-4">
        {{ trans('messages.repeat_each') }}
    </div>
    <div class="col-md-8">
        @include('events.meta.days__form')
    </div>

    <div class="col-md-4">
        {{ trans('messages.ends') }}
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="form-group col-md-12">
                <label>
                    <input type="radio" name="weekly_end_type" id="check_never" value="never" checked="checked" class="recur_type">
                    {{ trans('messages.never') }}
                </label>
            </div>
            <div class="form-group col-md-12">
                <label>
                    <input type="radio" name="weekly_end_type" id="check_after" value="at" class="recur_type">
                    {{ trans('messages.the') }}
                    <input type="date" name="weekly_meta_recur_end" id="weekly_meta_recur_end" value="" required="required" class="recur_end">
                </label>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkDisabled(evt) {
        var val = $("input[name=weekly_end_type]:checked").val();
        if(val == 'never') {
            $('#weekly_meta_recur_end').attr('disabled', true);
        } else {
            $('#weekly_meta_recur_end').removeAttr('disabled');
        }
    }
    $('input[name=weekly_end_type]:radio').change(checkDisabled);
    checkDisabled();
</script>