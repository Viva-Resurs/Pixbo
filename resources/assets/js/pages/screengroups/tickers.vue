/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <!-- TODO: Fix the styling of things-->
    <ticker-list :tickers="tickers" from="screengroup"></ticker-list>
</template>

<script type="text/ecmascript-6">
    import TickerList from '../../components/TickerList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {
        props: ['tickers', 'id'],

        components: { TickerList },
        mixins:[SweetAlert],

        methods: {
            attemptDeleteTicker(index) {
                this.confirm({
                    callback:this.deleteTicker, arg:index,
                    text: this.trans('screengroup.remove_association')
                })
            },

            deleteTicker: function (index) {
                var that = this
                client({ path: '/screengroups/' + this.id + '/ticker/' + this.tickers[index].id, method: 'DELETE' }).then(
                    function (response) {
                        that.tickers.splice(index, 1)
                        that.$dispatch('alert', {
                            message: that.trans('screengroup.ticker_association_removed'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('screengroup.ticker_association_removed_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        },

        ready() {
            this.$on('remove-ticker', function (index) {
                this.attemptDeleteTicker(index)
            })
        }
    }
</script>