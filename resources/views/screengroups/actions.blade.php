{!! Form::open(['route' => ['admin.screengroups.destroy', $item['id']], 'method' => 'delete']) !!}

<button id="delete_button{{$item['id']}}" type="button" class="btn btn-link" role="button" style="display:none;"
  data-toggle="modal" data-target="#confirmDelete" data-title="Delete ScreenGroup"
  data-message="Are you sure you want to delete this screen group?">
  Delete
</button>
@include('shared.delete_message')
{!! Form::close() !!}

<div class="btn-group pull-right">
    <a href="{{ route('admin.screengroups.edit', array($item['id'])) }}" class="btn">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right"
          title="{{ trans('messages.edit') }}"></span>
    </a>
    <label for="delete_button{{$item['id']}}" class="btn btn-link" role="button">
        <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right"
          title="{{ trans('messages.remove') }}"></span>
    </label>
</div>

<div class="btn-group pull-right">
    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('messages.edit') }} <span class="caret"></span>
    </button>

    <ul class="dropdown-menu" role="menu">

        <li><a href="{{ route('admin.screengroups.edit', array($item['id'])) }}">Edit</a></li>

        <li class="bg-danger">
           {!!
            Form::open(['method' => 'DELETE',
                'route' => ['admin.screengroups.destroy', $item['id']],
                'style' => 'display:inline']) !!}
                <button
                class="delete-button"
                type="button"
                data-toggle="modal"
                data-target="#confirmDelete"
                data-title="Delete ScreenGroup"
                data-message="Are you sure you want to delete this screen group?"
                >
                Delete
            </button>
            @include('shared.delete_message')
            {!! Form::close() !!}
        </li>
    </ul>
</div>
