<div class="modal fade" tabindex="-1" role="dialog" id="{{ $model }}_modal_{{ $item->id }}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('messages.edit') }}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        @include($model.'s.modal.head')
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <schedule id="{{ $item->id }}" model="{{ $model }}"></schedule>
                @include('shared.schedule.body')
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="schedule_form" class="btn btn-primary" onClick="submit_modal('{{ $model }}_modal_{{ $item->id }}', '#schedule_form_{{ $item->id }}')">{{ trans('messages.save') }}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  function submit_modal(targetModal, targetForm) {
    $(targetModal).modal('hide');
    $(targetForm).submit();
  }
</script>