<template>
    <div class="panel-heading">
        Ticker arkiv
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        Laddar data {{ loadingRouteData }}
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if="tickers.length == 0">
        Det finns inga tickers
    </div>

    <table class="table" v-if=" ! $loadingRouteData && tickers.length > 0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Text</th>

            <th width="120px">Aktion</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="ticker in tickers">
            <td>{{ ticker.id }}</td>
            <td>{{ ticker.text }}</td>
            <td>
                <a class="btn btn-primary btn-xs" v-link="{ path: '/tickers/'+ticker.id }">Ändra</a>
                <a class="btn btn-primary btn-xs" v-on:click="deleteTicker($index)">Ta bort</a>
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
                            // Look ma! Puppies!
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
                client({ path: '/ticker/' + this.tickers[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.tickers.splice(index, 1)
                            that.messages = [{type: 'success', message: 'Great, ticker purged.'}]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: 'There was a problem removing the ticker'})
                        }
                )
            }

        },

        route: {
            // Ooh, ooh, are there any new puppies yet?
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({tickers: data})
                })
            }
        }

    }
</script>
