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

            attemptDeleteTicker(index) {

                this.confirm({
                    callback:this.deleteTicker, arg:index,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteTicker(index) {

                var self = this;

                client({ path: '/screengroups/' + self.id + '/ticker/' + self.tickers[index].id, method: 'DELETE' }).then(

                    function (response) {

                        self.tickers.splice(index, 1);

                        self.$dispatch('alert', {
                            message: that.trans('screengroup.ticker_association_removed'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: that.trans('screengroup.ticker_association_removed_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function() {
            this.$on('remove-ticker', function (index) {
                this.attemptDeleteTicker(index);
            });
        }

    }
</script>
