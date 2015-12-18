<div class="btn-group pull-right">
    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-fire"></i> Actions <span class="caret"></span>
    </button>

    <ul class="dropdown-menu" role="menu">

        <li><a href="{{ route($model.'.show', array($item['id'])) }}">{{ trans('messages.show') }}</a></li>

        <li><a href="{{ route($model.'.edit', array($item['id'])) }}">{{ trans('messages.edit') }}</a></li>

        <li><a href="{{ route($model.'.destroy', array($item['id'])) }}">{{ trans('messages.destroy') }}</a></li>

    </ul>
</div>