<template>
    <div class="panel-heading">
        Edit Ticker
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
        <form class="form-horizontal" role="form" v-on:submit="updateScreengroup">
            <fieldset disabled>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-sm-offset-1 control-label">Ticker ID</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="name" type="text" v-model="ticker.id">
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-sm-offset-1 control-label">Ticker text</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" name="name" type="text" v-model="ticker.text">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-save"></i>Update the ticker!</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    module.exports = {

        data: function () {
            return {
                ticker: {
                    id: null,
                    text: null,
                },
                messages: []
            }
        },

        methods: {
            // Let's fetch the screengroup
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/tickers/' + id }).then(
                        function (response) {
                            that.$set('ticker', response.entity.ticker)
                            successHandler(response.entity.ticker)
                        },
                        function (response, status, request) {
                            // Go tell your parents that you've messed up somehow
                            if (status === 401) {
                                self.$dispatch('userHasLoggedOut')
                            } else {
                                console.log(response)
                            }
                        }
                )
            },

            updateScreengroup: function (e) {
                e.preventDefault()
                var self = this
                client({ path: '/tickers/' + this.ticker.id, entity: this.ticker, method: 'PUT'}).then(
                        function (response) {
                            self.messages = []
                            self.messages.push({type: 'success', message: 'Your ticker was updated'})
                        },
                        function (response) {
                            self.messages = []
                            for (var key in response.entity) {
                                self.messages.push({type: 'danger', message: response.entity[key]})
                            }
                        }
                )
            }

        },

        route: {
            // Ooh, ooh, are there any new puppies yet?
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({ticker: data})
                })
            }
        }
    }
</script>