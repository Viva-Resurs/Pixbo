<div class="weekly" style="display: none;">

    <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            {!!
                Form::number('weekly_frequency', 1, [
                    'id' => 'weekly_frequency',
                    'required' => 'required',
                    'min'=>'1',
                    'max' => '52',
                    'step' => '1',
                ])
            !!}
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
                    {!! Form::radio('weekly_end_type', 'never', null, ['id' => 'check_never', 'class' => 'recur_type']) !!}
                    {{ trans('messages.never') }}
                </label>
            </div>
            <div class="form-group col-md-12">
                <label>
                    {!!
                        Form::radio('weekly_end_type', 'at', null, [
                            'id' => 'check_after',
                            'class' => 'recur_type'
                        ])
                    !!}
                    {{ trans('messages.the') }}
                    {!!
                        Form::date('weekly_meta_recur_end', null, [
                            'id' => 'weekly_meta_recur_end',
                            'class' => 'recur_end'
                        ])
                    !!}
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