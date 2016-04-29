<template>
    <div class="panel-heading">
        {{ trans('ticker.create') }}
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
        <form class="form-horizontal" role="form" v-on:submit="createTicker">
            <div class="form-group">
                <label for="text" class="col-sm-2 col-sm-offset-1 control-label">Ticker text</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" name="text" type="text" v-model="ticker.text" id="nameInput">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary" :disabled="creating">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div></template>

<script>
    module.exports = {
        data: function () {
            return {
                ticker: {
                    text: '',
                },
                messages: [],
                creating: false
            }
        },

        methods: {
            createTicker: function (e) {
                e.preventDefault()
                var that = this
                that.creating = true
                client({path: 'tickers', entity: this.ticker}).then(
                        function (response, status) {
                            that.ticker.text = ''
                            that.messages = [{type: 'success', message: 'Your ticker was created'}]
                            Vue.nextTick(function () {
                                document.getElementById('nameInput').focus()
                            })
                            that.creating = false
                        },
                        function (response, status) {
                            that.messages = []
                            for (var key in response.entity) {
                                that.messages.push({type: 'danger', message: response.entity[key]})
                                that.creating = false
                            }
                        }
                )
            }
        }
    }
</script>

