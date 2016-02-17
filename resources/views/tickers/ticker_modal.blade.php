<div class="modal fade" tabindex="-1" role="dialog" id="ticker_modal_{{ $ticker->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-6 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="well well-lg">{{ $ticker->text }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="panel panel-default">
                      <div class="panel-body">
                            <schedule id="{{ $ticker->id }}" model="ticker"></schedule>
                            @include('shared.schedule__template')
                      </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->