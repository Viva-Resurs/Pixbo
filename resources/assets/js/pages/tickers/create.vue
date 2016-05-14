<template>
    <div class="panel-heading">
        {{ trans('ticker.create') }}
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" v-on:submit="createTicker">
            <div class="form-group">
                <label for="text" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.text') }}</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" name="text" type="text" v-model="ticker.text" id="nameInput">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="" class="btn" v-link="{ path: '/tickers/' }" v-if="emptyfields">
                      <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="" class="btn" v-link="{ path: '/tickers/' }" v-if="!emptyfields">
                      <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="emptyfields">
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
                }
            }
        },

        computed: {
             emptyfields: function(){
                return (this.ticker.text=='') ? true : false;
             },
            isValid() {
                // TODO: Add validation
            }
        },

        methods: {
            createTicker: function (e) {
                e.preventDefault()
                var self = this;
                client({path: 'tickers', entity: this.ticker}).then(
                    function (response, status) {
                        self.ticker.text = '';
                        self.$dispatch('alert', {
                            message: self.trans('ticker.created'),
                            options: {theme: 'success'}
                        })

                        Vue.nextTick(function () {
                            document.getElementById('nameInput').focus()
                        })
                    },
                    function (response, status) {
                        self.$dispatch('alert', {
                            message: self.trans('ticker.created_fail'),
                            options: {theme: 'error'}
                        })
                        /*
                        self.messages = []
                        for (var key in response.entity) {
                            self.messages.push({ type: 'danger', message: response.entity[key] });
                        }
                        */
                    }
                )
            }
        }
    }
</script>

