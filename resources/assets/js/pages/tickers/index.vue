<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>
        <ticker-list :tickers="tickers"></ticker-list>
    </div>

</template>

<script>
    import TickerList from '../../components/TickerList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    module.exports = {

        components: { TickerList },
        mixins:[SweetAlert],

        data: function () {
            return {
                tickers: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/tickers' }).then(
                    function (response) {
                        that.$set('tickers', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status, request) {
                        console.log('logged out?')
                    }
                )
            },

            attemptDeleteTicker(index) {
                this.confirm({callback:this.deleteTicker, arg:index})
            },

            deleteTicker: function (index) {
                var that = this
                client({ path: '/tickers/' + this.tickers[index].id, method: 'DELETE' }).then(
                    function (response) {
                        that.tickers.splice(index, 1)
                        that.$dispatch('alert', {
                            message: that.trans('ticker.deleted'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('ticker.delete_fail'),
                            options: {theme: 'error'}
                        })
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
        },

        ready() {
            this.$on('remove-ticker', function (index) {
                this.attemptDeleteTicker(index)
            })
        }

    }
</script>
