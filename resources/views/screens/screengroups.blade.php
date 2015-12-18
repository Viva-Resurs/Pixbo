<div class="panel panel-info"> <!-- Info -->
    <div class="panel-heading">
        <div class="panel-title">
            {{ trans('messages.screen_groups') }}
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="screengroup__listing">
            @foreach ($screengroups as $screengroup)
                <div class="col-lg-8">
                    {{ $screengroup->name }}
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="checkbox @if($errors->first('active')) has-error @endif">
                            <label for="active">
                                {!! Form::checkbox('active', null, null, ['id' => 'active']) !!}
                            </label>
                        </div>
                        <small class="text-danger">{{ $errors->first('active') }}</small>
                    </div>
                </div>
            @endforeach

            </div>
        </div>
    </div>
</div>