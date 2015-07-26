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
             {!! link_to_route('screengroups.show', 'Show', $screenGroup->id) !!}
            {!! link_to_route('screengroups.edit', 'Edit', $screenGroup->id) !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['screengroups.destroy', $screenGroup->id]]) !!}
                    <button type="submit">Delete</button>
                {!! Form::close() !!}
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
@else
    {{ 'No screengroups found.' }}
@endif