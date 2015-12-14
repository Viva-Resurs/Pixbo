<div class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@yield('modal-title')</h4>
      </div>
      <div class="modal-body">
        @yield('modal-body')
      </div>
      <div class="modal-footer">
        @yield('modal-footer')
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@yield('modal-js')