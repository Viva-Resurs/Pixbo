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

                {!! link_to_route('clients.show', 'Show', $client->id, ['class' => 'btn btn-default']) !!}
                {!! link_to_route('clients.edit', 'Edit', $client->id, ['class' => 'btn btn-default']) !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['clients.destroy', $client->id]]) !!}
                    <button type="submit" class="btn btn-warning">Delete</button>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@else
{{ "No clients exist." }}
@endif