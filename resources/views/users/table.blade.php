<table id="users_table" class="display" cellpadding="0" width="100%">
    <thead>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans_choice('messages.role',1) }}</th>
        <th>{{ trans_choice('messages.action',2) }}</th>
    </thead>
    <tfoot>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.name') }}</th>
        <th>{{ trans('messages.activity') }}</th>
        <th>{{ trans_choice('messages.role',1) }}</th>
        <th>{{ trans_choice('messages.action',2) }}</th>
    </tfoot>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}">
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->last_activity }}</td>
                <td>
                @foreach ($user->role as $role)
                    {{ $role }}
                @endforeach
                </td>
                <td>
                    @include('shared.actions', ['model' => 'admin.users', 'item' => $user, 'from' => $from])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>