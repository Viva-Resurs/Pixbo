<table id="client_table" class="display" cellpadding="0" width="100%">
    <thead>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.ip_address') }}</th>
        <th>{{ trans('messages.screen_group') }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans('messages.action') }}</th>
    </thead>
    <tfoot>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.ip_address') }}</th>
        <th>{{ trans('messages.screen_group') }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans('messages.action') }}</th>
    </tfoot>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->ip_address }}</td>
                <td>{{ $client->group }}</td>
                <td>{{ $client->activity }}</td>
                <td>{{ 'actions' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>