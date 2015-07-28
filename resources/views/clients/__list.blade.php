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
                {!! Form::open(['method' => 'DELETE', 'route' => ['clients.destroy', $client->id], 'style' => 'display:inline']) !!}
                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
                        <i rel="tooltip" title="Remove" class="glyphicon glyphicon-trash"></i>
                    </button>
                    @include('shared.delete_message')
                {!! Form::close() !!}
                @include('shared.delete_message')
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



@else
{{ "No clients exist." }}
@endif