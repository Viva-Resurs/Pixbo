<div class="form-group">
    <label class="col-sm-4 col-md-4 col-lg-4 control-label" for="name">{{ trans('messages.name') }}:</label>
    <div class="col-sm-5 col-md-5 col-lg-5">
    	{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    	<small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 col-md-4 col-lg-4 control-label" for="desc">{{ trans('messages.desc') }}:</label>
    <div class="col-sm-5 col-md-5 col-lg-5">
    	{!! Form::text('desc', null, ['class' => 'form-control', 'required' => 'required']) !!}
    	<small class="text-danger">{{ $errors->first('desc') }}</small>
    </div>
</div>

<div class="form-group">
	<div class="col-sm-5 col-sm-offset-4 col-md-5 col-md-offset-4 col-lg-5 col-lg-offset-4">
		<div class="btn-group pull-right">
    		{!! Form::submit(trans('messages.save'), ['class' => 'btn btn-primary']) !!}
		</div>
	</div>
</div>
