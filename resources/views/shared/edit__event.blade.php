<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            {{ trans('messages.event') }}
        </div>
    </div>
    <div class="panel-body">
        <table class="table">
            <tbody>
                {!! Form::model($event, ['method' => 'PATCH', 'route' => ['admin.events.update', $event->id]]) !!}
                    @include ('events.__form', ['submitButtonText' => trans('messages.save')])
                    <a class="btn btn-primary" data-toggle="modal" href='#event_meta'>{{ trans('messages.recurring') }}</a>
                {!! Form::close() !!}
            </tbody>
        </table>
    </div>
</div>