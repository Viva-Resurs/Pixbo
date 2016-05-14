<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

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
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/clients/'+client.id }"
                          v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-on:click="deleteClient($index)"
                          v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script>
    module.exports = {

        data: function () {
            return {
                clients: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/clients' }).then(
                    function (response) {
                        that.$set('clients', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            that.$dispatch('userHasLoggedOut')
                        }
                    }
                )
            },

            deleteClient: function (index) {
                var that = this
                client({ path: '/clients/' + this.clients[index].id, method: 'DELETE' }).then(
                    function (response) {
                        that.clients.splice(index, 1)
                        that.$dispatch('alert', {
                            message: that.trans('client.deleted'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('client.deleted_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({clients: data})
                })
            }
        }
    }
</script>
