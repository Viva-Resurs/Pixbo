<table id="client_table" class="display" cellpadding="0" width="100%">
    <thead>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.ip_address') }}</th>
        <th>{{ trans_choice('messages.screen_group',1) }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans_choice('messages.action',2) }}</th>
    </thead>
    <tfoot>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.ip_address') }}</th>
        <th>{{ trans_choice('messages.screen_group',1) }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans_choice('messages.action',2) }}</th>
    </tfoot>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>
                    <a href="{{ route('admin.clients.edit', $client->id) }}">
                        {{ $client->name }}
                    </a>
                </td>
                <td>{{ $client->ip_address }}</td>
                <td>{{ $client->group }}</td>
                <td>{{ $client->activity }}</td>
                <td>
                    @include('shared.actions', ['model' => 'admin.clients', 'item' => $client, 'preview' => $client->ip_address])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>