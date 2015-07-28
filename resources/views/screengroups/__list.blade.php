@if(count($screenGroups))
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th>{{ "id" }}</th>
        <th>{{ "name" }}</th>
        <th>{{ "description" }}</th>
        <th>{{ "event_id" }}</th>
        <th>{{ "created" }}</th>
        <th class="actions">{{ "Actions" }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($screenGroups as $screenGroup)
        <tr>
            <td>{{ $screenGroup->id }}</td>
            <td>{{ $screenGroup->name }}</td>
            <td>{{ $screenGroup->desc }}</td>
            <td>{{ $screenGroup->event_id }} </td>
            <td>{{ $screenGroup->created_at }}</td>
            <td class="actions">

                {!! link_to_route_html('screengroups.show', '<i rel="tooltip" title="Show" class="glyphicon glyphicon-zoom-in"></i>', $screenGroup->id, ['class' => 'btn btn-default']) !!}
                {!! link_to_route_html('screengroups.edit', '<i rel="tooltip" title="Edit" class="glyphicon glyphicon-edit"></i>', $screenGroup->id, ['class' => 'btn btn-default']) !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['screengroups.destroy', $screenGroup->id], 'style' => 'display:inline']) !!}
                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete ScreenGroup" data-message="Are you sure you want to delete this screen group ?">
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
    {{ 'No screengroups found.' }}
@endif