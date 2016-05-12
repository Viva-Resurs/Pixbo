<template>
    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if="clients.length == 0">
        You have no clients!
    </div>

    <table class="table" v-if=" ! $loadingRouteData && clients.length > 0">
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
            <td>{{ client.screengroup.name }}</td> <!-- TODO: need to fix transformer, so we can send screengroup(ID,NAME) -->
            <td>
                <a class="btn btn-primary btn-xs" v-link="{ path: '/clients/'+client.id }">Edit</a>
                <a class="btn btn-primary btn-xs" v-on:click="deleteClient($index)">Delete</a>
            </td>
        </tr>
        </tbody>
    </table></template>

<script>
    module.exports = {

        data: function () {
            return {
                clients: [],
                messages: []
            }
        },

        methods: {
            // Let's fetch some dogs
            fetch: function (successHandler) {
                var that = this
                client({ path: '/clients' }).then(
                        function (response) {
                            // Look ma! Puppies!
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
                            that.messages = [{type: 'success', message: 'Great, client purged.'}]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: 'There was a problem removing the client'})
                        }
                )
            }

        },

        route: {
            // Ooh, ooh, are there any new puppies yet?
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({clients: data})
                })
            }
        }

    }
</script>
