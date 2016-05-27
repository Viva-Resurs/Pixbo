<template>
    <div class="panel-heading">
        {{ trans('ticker.edit') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div v-if=" ! $loadingRouteData">
        <div class="panel-body">
            <form class="form-horizontal" role="form" v-on:submit="updateTicker">
                <fieldset disabled>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.id') }}</label>
                        <div class="col-sm-5">
                            <input class="form-control" required="required" name="name" type="text" v-model="ticker.id">
                        </div>
                    </div>
                </fieldset>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.text') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="name" type="text" v-model="ticker.text">
                    </div>
                </div>

                <schedule :model.sync="ticker" :screengroups="screengroups"></schedule>

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
        </div>
    </div>
</template>

<script>
    import Schedule from '../../components/Schedule.vue'

    module.exports = {

        data: function () {
            return {
                ticker: {
                    id: null,
                    text: null,
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
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/tickers/' + id }).then(
                        function (response) {
                            that.$set('ticker', response.entity.ticker)
                            successHandler(response.entity.ticker)
                        },
                        function (response, status, request) {
                            if (status === 401) {
                                self.$dispatch('userHasLoggedOut')
                            } else {
                                console.log(response)
                            }
                        }
                )
            },

            updateTicker: function (e) {
                e.preventDefault();
                var self = this;
                client({ path: '/tickers/' + this.ticker.id, entity: this.ticker, method: 'PUT'}).then(
                        function (response) {
                            self.$dispatch('alert', {
                                message: self.trans('ticker.created'),
                                options: {theme: 'success'}
                            })
                            self.$route.router.go('/tickers')
                        },
                        function (response) {
                            self.$dispatch('alert', {
                                message: self.trans('ticker.created_fail'),
                                options: {theme: 'error'}
                            })
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