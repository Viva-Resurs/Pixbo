<template>

    <ticker-list :tickers="tickers" from="screengroup"></ticker-list>

</template>

<script type="text/ecmascript-6">
    import TickerList from '../../components/TickerList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'SG_Ticker',

        props: [ 'tickers', 'id' ],

        components: { TickerList },

        mixins: [ SweetAlert ],

        methods: {

            attemptDeleteTicker(ticker) {

                this.confirm({
                    callback:this.deleteTicker, arg:ticker,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteTicker(ticker) {

                var self = this;

                client({ path: '/screengroups/' + self.id + '/ticker/' + ticker.id, method: 'DELETE' }).then(

                    function (response) {

                        ticker.removed = true;
                        self.tickers.reverse();

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.ticker_association_removed'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.ticker_association_removed_fail'),
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
        }

    }
</script>
