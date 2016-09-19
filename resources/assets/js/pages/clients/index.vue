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

        route: {
            data: function (transition) {
                client({ path: '/clients' }).then(
                    function (response) {
                        transition.next({clients: response.entity.data});
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
