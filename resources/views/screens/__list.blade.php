@if(count($screens))
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th>{{ "id" }}</th>
        <th>{{ "name" }}</th>
        <th>{{ "screengroup_id" }}</th>
        <th>{{ "event_id" }}</th>
        <th>{{ "image_id" }}</th>
        <th class="actions">{{ "Actions" }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($screens as $screen)
        <tr>
            <td>{{ $screen->id }}</td>
            <td>{{ $screen->name }}</td>
            <td>{{ $screen->screengroup_id }}</td>
            <td>{{ $screen->event_id }} </td>
            <td>{{ $screen->image_id }}</td>
            <td class="actions">

                {!!
                    link_to_route_html('screens.show',
                        '<i rel="tooltip" title="Show" class="glyphicon glyphicon-zoom-in"></i>',
                        $screen->id,
                        ['class' => 'btn btn-default']
                    )
                !!}
                {!!
                    link_to_route_html('screens.edit',
                        '<i rel="tooltip" title="Edit" class="glyphicon glyphicon-edit"></i>',
                        $screen->id,
                        ['class' => 'btn btn-default']
                    )
                !!}
                {!!
                    Form::open(['method' => 'DELETE',
                        'route' => ['screens.destroy', $screen->id],
                        'style' => 'display:inline']
                    )
                !!}
                    <button
                        class="btn btn-default"
                        type="button"
                        data-toggle="modal"
                        data-target="#confirmDelete"
                        data-title="Delete ScreenGroup"
                        data-message="Are you sure you want to delete this screen group ?">
                        <i rel="tooltip" title="Remove" class="glyphicon glyphicon-trash"></i>
                    </button>
                    @include('shared.delete_message')
                {!! Form::close() !!}
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
@else
    {{ 'No screens found.' }}
@endif