<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>

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

                    }

                );

            },

            attemptDeleteClient(clientob) {

                this.confirm({
                    callback: this.deleteClient, arg:clientob,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteClient(clientob) {

                var self = this;

                client({ path: '/clients/' + clientob.id, method: 'DELETE' }).then(

                    function (response) {

                        clientob.removed = true;
                        self.clients.reverse(); // Force vue to update view
                        
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
            this.$on('remove-client', function (clientob) {
                this.attemptDeleteClient(clientob);
            })
        },

        created: function(){
            this.fetch();
        }

    }
</script>
