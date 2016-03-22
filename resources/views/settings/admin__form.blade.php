<div class="form-group">
    <label for="vegas_delay">{{ trans('messages.vegas_delay') }}:</label>
    {!! Form::input('number', 'vegas_delay', $vegas_delay, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('vegas_delay') }}</small>
</div>

<div class="form-group">
    <label for="ticker_delay">{{ trans('messages.ticker_delay') }}:</label>
    {!! Form::input('number', 'ticker_delay', $ticker_delay, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('ticker_delay') }}</small>
</div>


<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>
