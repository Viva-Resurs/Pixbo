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

            attemptDeleteTicker(id) {

                this.confirm({
                    callback:this.deleteTicker, arg:id,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteTicker(tickerID) {

                var self = this;

                var removeIndex = -1;

                for (var i=0; i<self.tickers.length ; i++)
                    if (self.tickers[i].id == tickerID)
                        removeIndex = i;

                if (removeIndex==-1)
                    return self.$dispatch('alert', {
                        message: self.trans('screengroup.ticker_association_removed_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/screengroups/' + self.id + '/ticker/' + tickerID, method: 'DELETE' }).then(

                    function (response) {

                        self.tickers.splice(removeIndex, 1);

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
            this.$on('remove-ticker', function (id) {
                this.attemptDeleteTicker(id);
            });
        }

    }
</script>
