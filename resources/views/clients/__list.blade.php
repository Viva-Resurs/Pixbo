<!-- TODO: Language support -->
@if (count($clients))
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>{{ "id" }}</th>
            <th>{{ "name" }}</th>
            <th>{{ "ip" }}</th>
            <th>{{ "mac_address" }}</th>
            <th>{{ "screengroup" }}</th>
            <th>{{ "is_active" }}</th>
            <th>{{ "created" }}</th>
            <th class="actions">{{ "Actions" }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->ip_address }}</td>
            <td>{{ $client->mac_address }}</td>
            <td>
                {{ $client->screengroup->name }}
            </td>
            <td>{{ $client->is_active ? "Yes" : "No" }}</td>
            <td>{{ $client->created_at }}</td>
            <td class="actions">

                {!! link_to_route_html('clients.show', '<i rel="tooltip" title="Show" class="glyphicon glyphicon-zoom-in"></i>', $client->id, ['class' => 'btn btn-default']) !!}
                {!! link_to_route_html('clients.edit', '<i rel="tooltip" title="Edit" class="glyphicon glyphicon-edit"></i>', $client->id, ['class' => 'btn btn-default']) !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['clients.destroy', $client->id]]) !!}
                {!!Form::button('<i rel="tooltip" title="Remove" class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-default'))!!}
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



@else
{{ "No clients exist." }}
@endif