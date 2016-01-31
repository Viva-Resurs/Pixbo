<div class="btn-group">
    <a href="{{ route($model.'.edit', array($item['id'])) }}">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.edit') }}"></span>
    </a>
    <a href="{{ route($model.'.destroy', array($item['id'])) }}">
        <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
    </a>
</div>


