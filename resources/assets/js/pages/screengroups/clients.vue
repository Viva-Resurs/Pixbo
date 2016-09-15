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

            attemptDeleteClient(clientID) {

                this.confirm({
                    callback:this.deleteClient, arg:clientID,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteClient(clientID) {

                var self = this;

                var removeIndex = -1;

                for (var i=0; i<self.clients.length ; i++)
                    if (self.clients[i].id == clientID)
                        removeIndex = i;

                if (removeIndex==-1)
                    return self.$dispatch('alert', {
                        message: self.trans('screengroup.client_association_removed_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/screengroups/' + this.id + '/client/' + clientID, method: 'DELETE' }).then(
                    
                    function (response) {

                        self.clients.splice(removeIndex, 1);

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
            this.$on('remove-client', function (clientID) {
                this.attemptDeleteClient(clientID);
            });
        }

    }
</script>
