<template>

    <client-list :clients="clients" from="screengroup"></client-list>

</template>

<script type="text/ecmascript-6">
    import ClientList from '../../components/ClientList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'SG_Client',

        props: [ 'clients', 'id' ],

        components: { ClientList },

        mixins: [ SweetAlert ],

        methods: {

            attemptDeleteClient(clientob) {

                this.confirm({
                    callback:this.deleteClient, arg:clientob,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteClient(clientob) {

                var self = this;

                client({ path: '/screengroups/' + this.id + '/client/' + clientob.id, method: 'DELETE' }).then(
                    
                    function (response) {

                        clientob.removed = true;
                        self.clients.reverse(); // Force vue to update view

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.client_association_removed'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.client_association_removed_fail'),
                            options: {theme: 'error'}
                        });
                    }

                );

            }

        },

        ready() {
            this.$on('remove-client', function (clientob) {
                this.attemptDeleteClient(clientob);
            });
        }

    }
</script>
