<template>
    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-if=" ! $loadingRouteData">
        <div class="panel-body">
            <schedule :model.sync="ticker">
                <div slot="model_specific_setting">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <input type="text" v-model="ticker.text" name="ticker_text" id="inputTickerText" class="form-control" title="" required="required">
                            </div>
                        </div>
                    </div>
                </div>
            </schedule>
        </div>
    </div>
</template>

<script>
    import Schedule from '../../components/Schedule.vue'
    export default {

        components: { Schedule },

        data: function () {
            return {
                ticker: {}
            }
        },

        methods: {
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/tickers/' + id }).then(
                        function (response) {
                            that.$set('ticker', response.entity.data)
                            successHandler(response.entity.data)
                        },
                        function (response, status, request) {
                            if (status === 401) {
                                self.$dispatch('userHasLoggedOut')
                            }
                        }
                )
            }
        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({ticker: data})
                })
            }
        }
    }
</script>