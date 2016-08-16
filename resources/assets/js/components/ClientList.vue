/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>

    <div class="panel-body" v-if="clients.length == 0">
        {{ trans('client.empty') }}
    </div>

    <table class="table" v-if="clients.length > 0">
        <thead>
            <tr>
                <th>{{ trans('general.id') }}</th>
                <th>{{ trans('general.name') }}</th>
                <th v-if="$root.isAdmin">{{ trans('general.mac_address') }}</th>
                <th v-if="this.from!='screengroup'">{{ trans('screengroup.model', 1) }}</th>
                <th width="120px">{{ trans('general.action') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="client in clients">
                <td>{{ client.id }}</td>
                <td>
                    <a v-link="{ path: '/clients/'+client.id }" v-if="$root.isAdmin">{{ client.name }}</a>
                    <span v-else>{{ client.name }}</span>
                </td>
                <td v-if="$root.isAdmin">{{ client.address }}</td>
                <td v-if="this.from!='screengroup'">{{ client.screengroup.data.name }}</td>
                <td>
                    <a class="btn btn-primary btn-xs fa fa-eye" href="/play?mac={{client.address}}&preview=yes" target="_blank"
                       v-tooltip data-original-title="{{ trans('general.preview') }}"></a>
                    <template v-if="$root.isAdmin">
                    <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/clients/'+client.id }"
                       v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                    <a v-if="this.from=='screengroup'" class="btn btn-primary btn-xs fa fa-minus" v-on:click="removeClient($index)"
                       v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></a>
                    <a v-else class="btn btn-primary btn-xs fa fa-times" v-on:click="removeClient($index)"
                       v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </template>
                </td>
            </tr>
        </tbody>
    </table>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'ClientList',

        props: ['clients','from'],

        methods: {
            removeClient(index) {
                this.$dispatch('remove-client', index);
            }
        }
        
    }
</script>
