<div class="btn-group">
    <a href="{{ route($model.'.edit', array($item['id'])) }}">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.edit') }}"></span>
    </a>
    <a href="{{ route($model.'.destroy', array($item['id'])) }}">
        <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
    </a>
    @if(isset($preview))
         <a href="{{ route('play.index', ['mac' => $preview]) }}" target="_blank">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.preview') }}"></span>
    </a>
    @endif
</div>


