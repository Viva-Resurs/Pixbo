<div class="yearly" style="display: none;">

    <div class="col-md-4">
        {{ trans('messages.repeat_every') }}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            {!!
                Form::number('yearly_frequency', null, [
                    'id' => 'yearly_frequency',
                    'required' => 'required',
                    'min'=>'1',
                    'max' => '10',
                    'step' => '1',
                ])
            !!}
            {{ trans('messages.years') }}
        </div>
    </div>

    <div class="col-md-4">
        {{ trans('messages.ends') }}
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="form-group col-md-12">
                <label>
                    {!! Form::radio('yearly_end_type', 'never', null, ['id' => 'check_never', 'class' => 'recur_type']) !!}
                    {{ trans('messages.never') }}
                </label>
            </div>
            <div class="form-group col-md-12">
                <label>
                    {!!
                        Form::radio('yearly_end_type', 'at', null, [
                            'id' => 'check_after',
                            'class' => 'recur_type'
                        ])
                    !!}
                    {{ trans('messages.the') }}
                    {!!
                        Form::date('yearly_meta_recur_end', null, [
                            'id' => 'yearly_meta_recur_end',
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
        var val = $("input[name=yearly_end_type]:checked").val();
        if(val == 'never') {
            $('#yearly_meta_recur_end').attr('disabled', true);
        } else {
            $('#yearly_meta_recur_end').removeAttr('disabled');
        }
    }
    $('input[name=yearly_end_type]:radio').change(checkDisabled);
    checkDisabled();
</script>