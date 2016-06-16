<template>

    <div class="panel-heading">
        {{ trans('ticker.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <schedule :model.sync="ticker">
                <div slot="model_specific_setting">
                    <div class="form-group">
                        <label for="ticker_text" class="model_label">{{ trans('general.text') }}</label>
                        <div class="model_input">
                            <input class="form-control"
                                   name="ticker_text" id="inputTickerText"
                                   type="text"
                                   v-model="ticker.text"
                                   required
                            >
                        </div>
                    </div>
                    <hr>
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
                var self = this
                client({ path: '/tickers/' + id }).then(
                        function (response) {
                            self.$set('ticker', response.entity.data)
                            
                            if ( self.$route.query.screengroup )
                                self.ticker.screengroups.push( { id: self.$route.query.screengroup });

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