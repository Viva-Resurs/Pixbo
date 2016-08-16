<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>
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

                client({ path: '/tickers' }).then(

                    function (response) {

                        self.$set('tickers', response.entity.data);

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        if (!self.attempts || self.attempts < 3)

                            setTimeout(function(){

                                self.attempts = (self.attempts) ? self.attempts+1 : 1;
                                self.fetch();

                            },1000);

                    }

                );

            },

            attemptDeleteTicker(index) {

                this.confirm({
                    callback:this.deleteTicker, arg:index,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteTicker(index) {

                var self = this;

                client({ path: '/tickers/' + self.tickers[index].id, method: 'DELETE' }).then(
                    
                    function (response) {

                        self.tickers.splice(index, 1);

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
