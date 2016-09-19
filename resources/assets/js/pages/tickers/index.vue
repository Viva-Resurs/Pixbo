<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>
        <ticker-list :tickers="tickers"></ticker-list>
    </div>

</template>

<script type="text/ecmascript-6">
    import TickerList from '../../components/TickerList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { TickerList },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                tickers: []
            }
        },

        methods: {

            attemptDeleteTicker(ticker) {

                this.confirm({
                    callback:this.deleteTicker, arg:ticker,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteTicker(ticker) {

                var self = this;

                client({ path: '/tickers/' + ticker.id, method: 'DELETE' }).then(
                    
                    function (response) {

                        ticker.removed = true;
                        self.tickers.reverse(); // Force vue to update view

                        self.$dispatch('alert', {
                            message: self.trans('ticker.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('ticker.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function() {
            this.$on('remove-ticker', function (ticker) {
                this.attemptDeleteTicker(ticker);
            });
        },

        route: {
            data: function (transition) {
                client({ path: '/tickers' }).then(
                    function (response) {
                        transition.next({tickers: response.entity.data});
                    },
                    function (response){
                        transition.next();
                        console.error(response.entity.error);
                    }
                );
            }
        }

    }
</script>
