<div class="btn-group pull-right">
    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-fire"></i> Actions <span class="caret"></span>
    </button>

    <ul class="dropdown-menu" role="menu">

        <li><a href="{{ route('admin.clients.show', array($item['id'])) }}">View</a></li>

        <li><a href="{{ route('admin.clients.edit', array($item['id'])) }}">Edit</a></li>

        <!-- <li><a href="{{ route('clients.destroy', array($item['id'])) }}">Delete</a></li> -->
            <li>
         {!!
            Form::open(['method' => 'DELETE',
                'route' => ['admin.events.destroy', $item['id']],
                'style' => 'display:inline']) !!}
                    <button
                        class="delete-button"
                        type="button"
                        data-toggle="modal"
                        data-target="#confirmDelete"
                        data-title="Delete Event"
                        data-message="Are you sure you want to delete this event?"
                    >
                        Delete
                    </button>
                    @include('shared.delete_message')
                {!! Form::close() !!}
                </li>

    </ul>
</div>
