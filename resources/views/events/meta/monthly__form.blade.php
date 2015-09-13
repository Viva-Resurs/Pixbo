<div class="monthly" style="display: none;">

   <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            {!!
                Form::number('monthly_frequency', null, [
                    'id' => 'monthly_frequency',
                    'required' => 'required',
                    'min'=>'1',
                    'max' => '10',
                    'step' => '1',
                ])
            !!}
            {{ trans('messages.months') }}
        </div>
    </div>

    <div class="col-md-4">
        {{ trans('messages.the') }}
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-3">
            {!!
                Form::select('monthly_recur_day_num', array(
                        '1' => trans("messages.first"),
                        '2' => trans('messages.second'),
                        '3' => trans('messages.third'),
                        '4' => trans('messages.fourth'),
                        '5' => trans('messages.last')
                    ), null, [
                        'id' => 'monthly_recur_day_num',
                        'class' => 'form-group selectpicker',
                        'required' => 'required'
                ])
            !!}
            </div>
            <div class="col-md-4">
                {!!
                    Form::select('monthly_recur_day', array(
                            '1' => trans("messages.monday"),
                            '2' => trans('messages.tuesday'),
                            '3' => trans('messages.wednesday'),
                            '4' => trans('messages.thursday'),
                            '5' => trans('messages.friday'),
                            '6' => trans('messages.saturday'),
                            '0' => trans('messages.sunday')
                        ), null, [
                            'id' => 'monthly_recur_day',
                            'class' => 'form-group selectpicker',
                            'required' => 'required'
                    ])
                !!}
            </div>
            <div class="col-md-5">
                {{ trans('messages.each_month') }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        {{ trans('messages.ends') }}
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="form-group col-md-12">
                <label>
                    {!! Form::radio('monthly_end_type', 'never', null, ['id' => 'check_never', 'class' => 'recur_type']) !!}
                    {{ trans('messages.never') }}
                </label>
            </div>
            <div class="form-group col-md-12">
                <label>
                    {!!
                        Form::radio('monthly_end_type', 'at', null, [
                            'id' => 'check_after',
                            'class' => 'recur_type'
                        ])
                    !!}
                    {{ trans('messages.the') }}
                    {!!
                        Form::date('monthly_meta_recur_end', null, [
                            'id' => 'monthly_meta_recur_end',
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
        var val = $("input[name=monthly_end_type]:checked").val();
        if(val == 'never') {
            $('#monthly_meta_recur_end').attr('disabled', true);
        } else {
            $('#monthly_meta_recur_end').removeAttr('disabled');
        }
    }
    $('input[name=monthly_end_type]:radio').change(checkDisabled);
    checkDisabled();
</script>