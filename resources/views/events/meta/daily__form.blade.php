<div class="daily">
    <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
        {!!
            Form::number('daily_frequency', null, [
                'id' => 'daily_frequency',
                'required' => 'required',
                'min'=>'1',
                'max' => '365',
                'step' => '1',
            ])
        !!}

            {{ trans('messages.days') }}
        </div>
    </div>

    <div class="col-md-4">
        {{ trans('messages.ends') }}
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="form-group col-md-12">
                <label>
                    {!! Form::radio('daily_end_type', 'never', null, ['id' => 'check_never', 'class' => 'recur_type']) !!}
                    {{ trans('messages.never') }}
                </label>
            </div>
            <div class="form-group col-md-12">
                <label>
                    {!!
                        Form::radio('daily_end_type', 'at', null, [
                            'id' => 'check_after',
                            'class' => 'recur_type'
                        ])
                    !!}
                    {{ trans('messages.the') }}
                    {!!
                        Form::date('daily_meta_recur_end', null, [
                            'id' => 'daily_meta_recur_end',
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
        var val = $("input[name=daily_end_type]:checked").val();
        if(val == 'never') {
            $('#daily_meta_recur_end').attr('disabled', true);
        } else {
            $('#daily_meta_recur_end').removeAttr('disabled');
        }
    }
    $('input[name=daily_end_type]:radio').change(checkDisabled);
    checkDisabled();
</script>