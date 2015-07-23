<!-- TODO: Language support -->
@if (count($clients))
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>ip</th>
            <th>mac_address</th>
            <th>screengroup_id</th>
            <th>is_active</th>
            <th>created</th>
            <th class="actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->ip }}</td>
            <td>{{ $client->mac_address }}</td>
            <td>
                {{ "Screengroup id with link" }}
            </td>
            <td>{{ $client->is_active ? "Yes" : "No" }}</td>
            <td>{{ $client->created_at }}</td>
            <td class="actions">
                {{ "Preview" }}
                {{ "Show" }}
                {{ "Edit" }}
                {{ "Delete" }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@else
{{ "No clients exist." }}
@endif