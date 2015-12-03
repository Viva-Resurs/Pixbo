<div class="panel panel-info"> <!-- Info -->
    <div class="panel-heading">
        <div class="panel-title">
            {{ trans('messages.info') }}
        </div>
    </div>
    <div class="panel-body">
        {!! Form::model($screengroup, ['method' => 'PATCH', 'route' => ['admin.screengroups.update', $screengroup->id]]) !!}
            @include ('screengroups.__form', ['submitButtonText' => trans('messages.save')])
        {!! Form::close() !!}
    </div>
</div>