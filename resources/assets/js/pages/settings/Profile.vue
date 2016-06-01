<template>
    <div class="panel-heading">
        {{ trans('auth.profile') }}
    </div>
    <div class="panel-body">
        <table class="table table-bordered" v-if="$root.user">
            <tr>
                <th>{{ trans('general.id') }}</th>
                <th>{{ trans('general.name') }}</th>
                <th>{{ trans('general.email') }}</th>
            </tr>
            <tr>
                <td>{{ $root.user.id }}</td>
                <td>{{ $root.user.name }}</td>
                <td>{{ $root.user.email }}</td>
            </tr>
        </table>
    </div>
</template>