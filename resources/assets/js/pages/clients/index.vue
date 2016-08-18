<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <client-list :clients="clients"></client-list>
        
    </div>

</template>

<script type="text/ecmascript-6">
    import ClientList from '../../components/ClientList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { ClientList },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                clients: []
            }
        },

        methods: {

            fetch() {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/clients' }).then(

                    function (response) {

                        self.$set('clients', response.entity.data);
                        
                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                        if (!self.attempts || self.attempts < 3)

                            setTimeout(function(){

                                self.attempts = (self.attempts) ? self.attempts+1 : 1;
                                self.fetch();

                            },1000);

                    }

                );

            },

            attemptDeleteClient(index) {

                this.confirm({
                    callback: this.deleteClient, arg:index,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteClient(index) {

                var self = this;

                client({ path: '/clients/' + self.clients[index].id, method: 'DELETE' }).then(

                    function (response) {

                        self.clients.splice(index, 1);
                        self.$dispatch('alert', {
                            message: self.trans('client.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('client.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function() {
            this.$on('remove-client', function (index) {
                this.attemptDeleteClient(index);
            })
        },

        created: function(){
            this.fetch();
        }

    }
</script>
