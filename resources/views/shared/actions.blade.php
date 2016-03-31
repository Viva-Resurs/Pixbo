    {!! Form::open(['route' => [$model.'.destroy', $item['id']], 'method' => 'delete']) !!}
        <button id="delete_button{{$item['id']}}" type="submit" class="btn btn-link" role="button" style="display:none;"></button>
    {!! Form::close() !!}
<div class="btn-group" role="group">
    @if(isset($modal))
        <a data-toggle="modal" data-target="{{ '#'.$modal.'_modal_'.$item->id }}" class="btn btn-link">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right"
              title="{{ trans('messages.edit') }}"></span>
        </a>
    @else
        <a href="{{ route($model.'.edit', array($item['id'])) }}" class="btn btn-link">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right"
              title="{{ trans('messages.edit') }}"></span>
        </a>
    @endif
        <label for="delete_button{{$item['id']}}" class="btn btn-link" role="button">
          <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right"
            title="{{ trans('messages.remove') }}"></span>
        </label>
    @if(isset($preview))
        <a href="{{ route('play.index', ['mac' => $preview, 'preview' => true]) }}" target="_blank" class="btn btn-link">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true" data-toggle="tooltip" data-placement="right"
              title="{{ trans('messages.preview') }}"></span>
        </a>
    @endif
</div>