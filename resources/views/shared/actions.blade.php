<div class="btn-group">
    <div class="btn-group">
        @if(isset($modal))
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="{{ '#'.$modal.'_modal_'.$item->id }}" role="button">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.edit') }}"></span>
            </button>
        @else
        <a href="{{ route($model.'.edit', array($item['id'])) }}" class="btn btn-link">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.edit') }}"></span>
        </a>
        @endif
    </div>
    @if(isset($from) && $from=='screengroup')
    @else
        <div class="btn-group">
            {!! Form::open(['route' => [$model.'.destroy', $item['id']], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-link" role="button">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                </button>
            {!! Form::close() !!}
        </div>
    @endif
    @if(isset($preview))
        <div class="btn-group">
            <a href="{{ route('play.index', ['mac' => $preview, 'preview' => true]) }}" target="_blank" class="btn btn-link">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.preview') }}"></span>
            </a>
        </div>
    @endif
</div>


