<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <client-list :clients="clients"></client-list>
        
    </div>

</template>

<script>
    import ClientList from '../../components/ClientList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    module.exports = {

        components: { ClientList },
        mixins:[SweetAlert],

        data: function () {
            return {
                clients: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/clients' }).then(
                    function (response) {
                        that.$set('clients', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status) {
                        console.log('logged out?')
                    }
                )
            },

            attemptDeleteClient(index) {
                this.confirm({callback:this.deleteClient, arg:index})
            },

            deleteClient: function (index) {
                var that = this
                client({ path: '/clients/' + this.clients[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.clients.splice(index, 1)
                            that.$dispatch('alert', {
                                message: that.trans('client.deleted'),
                                options: {theme: 'success'}
                            })
                        },
                        function (response) {
                            that.$dispatch('alert', {
                                message: that.trans('client.deleted_fail'),
                                options: {theme: 'error'}
                            })
                        }
                )
            }
        },

        ready() {
          this.$on('remove-client', function (index) {
              this.attemptDeleteClient(index)
          })
        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({clients: data})
                })
            }
        }
    }
</script>
