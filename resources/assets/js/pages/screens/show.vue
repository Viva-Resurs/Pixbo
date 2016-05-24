<template>
    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-if=" ! $loadingRouteData">
        <div class="panel-body">
           <schedule :model.sync="screen"></schedule>
        </div>
    </div>
</template>

<script>
    module.exports = {

        // TODO: Clean this up abit...

        components: {
            Schedule: require('./../../components/Schedule.vue')
        },

        data: function () {
            return {
                screen: {},
                screengroups: []
            }
        },

        methods: {
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/screens/' + id }).then(
                        function (response) {
                            that.$set('screen', response.entity.data)
                            successHandler(response.entity.data)
                        },
                        function (response, status, request) {
                            if (status === 401) {
                                self.$dispatch('userHasLoggedOut')
                            } else {
                                //console.log(response)
                            }
                        }
                )
            },


            updateScreen: function (e) {
                e.preventDefault()
                var self = this
                client({ path: '/screens/' + this.screen.id, entity: this.screen, method: 'PUT'}).then(
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screen.updated'),
                            options: {theme: 'success'}
                        })

                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screen.updated_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({screen: data})
                })
            }
        }
    }
</script>