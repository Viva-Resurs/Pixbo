<template>
    <div class="panel-heading">
        {{ trans('ticker.archive') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if="tickers.length == 0">
        {{ trans('ticker.empty') }}
    </div>

    <table class="table" v-if=" ! $loadingRouteData && tickers.length > 0">
        <thead>
        <tr>
            <th>{{ trans('general.id') }}</th>
            <th>{{ trans('general.text') }}</th>

            <th width="120px">{{ trans('general.action') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="ticker in tickers">
            <td>{{ ticker.id }}</td>
            <td>{{ ticker.text }}</td>
            <td>
                <a class="btn btn-primary btn-xs" v-link="{ path: '/tickers/'+ticker.id }">{{ trans('general.edit') }}</a>
                <a class="btn btn-primary btn-xs" v-on:click="deleteTicker($index)"> {{ trans('general.delete') }}</a>
            </td>
        </tr>
        </tbody>
    </table></template>

<script>
    module.exports = {

        data: function () {
            return {
                tickers: [],
                messages: []
            }
        },

        methods: {
            // Let's fetch some dogs
            fetch: function (successHandler) {
                var that = this
                client({ path: '/tickers' }).then(
                        function (response) {
                            that.$set('tickers', response.entity.data)
                            successHandler(response.entity.data)
                        },
                        function (response, status) {
                            if (_.contains([401, 500], status)) {
                                that.$dispatch('userHasLoggedOut')
                            }
                        }
                )
            },

            deleteTicker: function (index) {
                var that = this
                client({ path: '/tickers/' + this.tickers[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.tickers.splice(index, 1)
                            that.messages = [{type: 'success', message: that.trans('ticker.deleted') }]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: that.trans('ticker.delete_fail') })
                        }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({tickers: data})
                })
            }
        }

    }
</script>
