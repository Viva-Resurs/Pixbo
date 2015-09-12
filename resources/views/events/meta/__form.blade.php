

<div class="modal fade" id="event_meta">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('messages.recurring') }}</h4>
            </div>

            {!! Form::model($event_meta, ['method' => 'PATCH', 'route' => ['admin.eventmetas.update', $event_meta->id]], ['class' => 'form-horizontal', 'id' => 'event_meta_form']) !!}
            {{ csrf_field() }}
                <div class="modal-body row">
                    <div class="col-md-4">
                        {{ trans('messages.repeat') }}
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select name="recurrence" id="recurrence" class="" required="required">
                                <option value="daily">{{ trans('messages.daily') }}</option>
                                <option value="weekly">{{ trans('messages.weekly') }}</option>
                                <option value="monthly">{{ trans('messages.monthly') }}</option>
                                <option value="Yearly">{{ trans('messages.yearly') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="recurrence-settings">
                        @include('events.meta.daily__form')
                        @include('events.meta.weekly__form')
                        @include('events.meta.monthly__form')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>
                    {!! Form::submit(trans('messages.save'), ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('footer')
    @parent

    <script type="text/javascript">
        $('#event_meta').on('shown.bs.modal', function () {
            $('#recurrence').focus();
        })
        $('select').on('change', function() {
            var val = this.value;
            if(val == 'daily') {
                $('.daily').removeAttr('style');
                $('.weekly').attr('style', "display: none;");
                $('.monthly').attr('style', "display: none;");
                $('.yearly').attr('style', "display: none;");
            } else if(val == 'weekly') {
                $('.daily').attr('style', "display: none;");
                $('.weekly').removeAttr('style');
                $('.monthly').attr('style', "display: none;");
                $('.yearly').attr('style', "display: none;");
            } else if(val == 'monthly') {
                $('.daily').attr('style', "display: none;");
                $('.weekly').attr('style', "display: none;");
                $('.monthly').removeAttr('style');
                $('.yearly').attr('style', "display: none;");
            } else if(val == 'yearly') {
                $('.daily').attr('style', "display: none;");
                $('.weekly').attr('style', "display: none;");
                $('.monthly').attr('style', "display: none;");
                $('.yearly').removeAttr('style');
            }
        });
    </script>
    <script type="text/javascript">

        function addAlert(message, type) {
            $('#alerts').append(
                '<div class="alert alert-'+ type +'">' +
                '<button type="button" class="close" data-dismiss="alert">' +
                '&times;</button>' + message + '</div>');
        }

        var frm = $('#event_meta_form');
        frm.submit(function (ev) {
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    $('#event_meta').modal('hide');
                    addAlert("{{ trans('messages.repeat_success_updated') }}", "success");
                },
                error: function (data) {
                    $('#event_meta').modal('hide');
                    addAlert("{{ trans('messages.repeat_error_updated') }}", 'danger');
                }
            });
            ev.preventDefault();
        });
    </script>
@stop