<div class="form-group">
    <label for="name">{{ trans('messages.name') }}:</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    <label for="desc">{{ trans('messages.desc') }}:</label>
    {!! Form::text('desc', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('desc') }}</small>
</div>

<div class="form-group">
    {!! Form::label('rss_feed', 'RSS Feed:') !!}
    {!! Form::text('rss_feed', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('rss_feed') }}</small>
</div>

<div class="btn-group pull-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
</div>
