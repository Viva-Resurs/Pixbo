<div class="btn-group pull-right" role="group">
    @can('edit_'.$from)
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
    @endcan
    @can('remove_'.$from)
        @if($from=='screengroups' && $model!='admin.screengroups')
            <a href="/admin/screengroups/{{ $screengroup->id }}/{{get_model_name($model)}}/{{ $item->id }}/remove_{{get_model_name($model)}}_association">
              <span class="glyphicon glyphicon-minus" aria-hidden="true" data-toggle="tooltip" data-placement="right"
                title="{{ trans('messages.remove_association_tooltip', ['association' => $screengroup->name]) }}"></span>
            </a>
        @else
            <label for="delete_button{{$item['id']}}" class="btn btn-link" role="button">
              <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right"
                title="{{ trans('messages.remove') }}"></span>
            </label>
        @endif
    @endcan
    @if(isset($preview))
        <a href="{{ route('play.index', ['mac' => $preview, 'preview' => true]) }}" target="_blank" class="btn btn-link">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true" data-toggle="tooltip" data-placement="right"
              title="{{ trans('messages.preview') }}"></span>
        </a>
    @endif
</div>
@can('remove_'.$from)
    @if($from!='screengroups' || $model=='admin.screengroups')
        {!! Form::open(['route' => [$model.'.destroy', $item['id']], 'method' => 'delete']) !!}
            <button id="delete_button{{$item['id']}}" type="submit" class="btn btn-link" role="button" style="display:none;"></button>
        {!! Form::close() !!}
    @endif
@endcan