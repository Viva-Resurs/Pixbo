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

            attemptDeleteClient(index) {

                this.confirm({
                    callback:this.deleteClient, arg:index,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteClient(index) {

                var self = this;

                client({ path: '/screengroups/' + this.id + '/client/' + this.clients[index].id, method: 'DELETE' }).then(
                    
                    function (response) {

                        self.clients.splice(index, 1);

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
            this.$on('remove-client', function (index) {
                this.attemptDeleteClient(index);
            });
        }

    }
</script>
