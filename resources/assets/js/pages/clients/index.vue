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

            attemptDeleteClient(clientID) {

                this.confirm({
                    callback: this.deleteClient, arg:clientID,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
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
                        message: self.trans('client.deleted_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/clients/' + clientID, method: 'DELETE' }).then(

                    function (response) {

                        self.clients.splice(removeIndex, 1);
                        
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
            this.$on('remove-client', function (clientID) {
                this.attemptDeleteClient(clientID);
            })
        },

        created: function(){
            this.fetch();
        }

    }
</script>
