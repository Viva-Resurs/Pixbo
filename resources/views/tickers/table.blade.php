<table id="ticker_table" class="display" cellpadding="0" width="100%">
    <thead>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.text') }}</th>
        <th>{{ trans_choice('messages.screen_group', 1) }}</th>
        <th>{{ trans('messages.summary') }}</th>
        <th>{{ trans_choice('messages.action',2) }}</th>
    </thead>
    <tfoot>
        <th>{{ trans('messages.id') }}</th>
        <th>{{ trans('messages.text') }}</th>
        <th>{{ trans_choice('messages.screen_group', 1) }}</th>
        <th>{{ trans('messages.summary') }}</th>
        <th>{{ trans_choice('messages.action',2) }}</th>
    </tfoot>
    <tbody>
        @foreach ($tickers as $ticker)
            <tr>
                <td>{{ $ticker->id }}</td>
                <td>{{ $ticker->text }}</td>
                <td>
                @foreach ($ticker->screengroups as $screengroup)
                    {{ $screengroup->name }}
                @endforeach
                </td>
                <td>
                    {{ 'Summary' }}
                </td>

                <td>
                    @include('shared.actions', ['model' => 'admin.tickers', 'item' => $ticker])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>