/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>

    <div class="panel-section" v-if="clients.length == 0">
        {{ trans('client.empty') }}
    </div>

    <div class="panel-section" v-if="clients.length > 0">

        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('general.name') }}</th>
                    <th v-if="this.from!='screengroup'">{{ trans('screengroup.model', 1) }}</th>
                    <th class="slim" v-if="$root.isAdmin">{{ trans('general.mac_address') }}</th>
                    <th class="slim">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients">
                    <td>
                        <a v-link="{ path: '/clients/'+client.id }" v-if="$root.isAdmin">{{ client.name }}</a>
                        <span v-else>{{ client.name }}</span>
                    </td>
                    <td v-if="this.from!='screengroup'">{{ client.screengroup.data.name }}</td>
                    <td class="slim" v-if="$root.isAdmin">{{ client.address }}</td>
                    <td class="slim">
                        <a class="btn btn-primary btn-xs fa fa-eye" href="/play?mac={{client.address}}&preview=yes" target="_blank"
                           v-tooltip data-original-title="{{ trans('general.preview') }}"></a>
                        <template v-if="$root.isAdmin">
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/clients/'+client.id }"
                           v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a v-if="this.from=='screengroup'" class="btn btn-primary btn-xs fa fa-minus" v-on:click="removeClient(client.id)"
                           v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></a>
                        <a v-else class="btn btn-primary hover-danger btn-xs fa fa-times" v-on:click="removeClient(client.id)"
                           v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'ClientList',

        props: ['clients','from'],

        methods: {
            removeClient(clientID) {
                this.$dispatch('remove-client', clientID);
            }
        }
        
    }
</script>
