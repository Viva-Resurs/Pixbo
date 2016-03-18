<div class="modal fade" tabindex="-1" role="dialog" id="{{ $model }}_modal_{{ $item->id }}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('messages.edit') }}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            @if($model == 'screen')
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            @include($model.'s.modal.head')
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <schedule id="{{ $item->id }}" model="{{ $model }}"></schedule>
                @include('shared.schedule.body')
            </div>
        </div>
      </div>
      <div class="modal-footer">
        @include('shared.schedule.submit_button')
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->