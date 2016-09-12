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

            fetch() {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/tickers' }).then(

                    function (response) {

                        self.$set('tickers', response.entity.data);

                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                    }

                );

            },

            attemptDeleteTicker(id) {

                this.confirm({
                    callback:this.deleteTicker, arg:id,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
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

                client({ path: '/tickers/' + tickerID, method: 'DELETE' }).then(
                    
                    function (response) {

                        self.tickers.splice(removeIndex, 1);

                        self.$dispatch('alert', {
                            message: self.trans('ticker.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('ticker.delete_fail'),
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
        },

        created: function(){
            this.fetch();
        }

    }
</script>
