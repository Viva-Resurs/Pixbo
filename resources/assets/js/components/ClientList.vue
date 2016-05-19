/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <div class="panel-body" v-if=" clients.length == 0 ">
        {{ trans('client.empty') }}
    </div>

    <table class="table" v-if=" clients.length > 0 ">
        <thead>
        <tr>
            <th>{{ trans('general.id') }}</th>
            <th>{{ trans('general.name') }}</th>
            <th>{{ trans('general.ip_address') }}</th>
            <th>{{ trans_choice('screengroup.model', 1) }}</th>
            <th width="120px">{{ trans('general.action') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="client in clients">
            <td>{{ client.id }}</td>
            <td>{{ client.name }}</td>
            <td>{{ client.ip_address }}</td>
            <td>{{ client.screengroup.data.name }}</td>
            <td>
                <a class="btn btn-primary btn-xs fa fa-eye" href="/play?mac={{client.ip_address}}" target="_blank"
                   v-tooltip data-original-title="{{ trans('general.preview') }}"></a>
                <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/clients/'+client.id }"
                   v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                <a class="btn btn-primary btn-xs fa fa-times" v-on:click="removeClient($index)"
                   v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script type="text/ecmascript-6">
    export default {
        props: ['clients'],

        methods: {
            removeClient(index) {
                this.$dispatch('remove-client', index)
            }
        }
    }
</script>

<style>

</style>