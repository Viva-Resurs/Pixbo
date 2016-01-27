<table id="user_table" class="display" cellpadding="0" width="100%">
    <thead>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans('messages.action') }}</th>
    </thead>
    <tfoot>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans('messages.action') }}</th>
    </tfoot>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->last_activity }}</td>
                <td>{{ 'actions' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>