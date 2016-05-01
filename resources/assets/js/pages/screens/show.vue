<template>
    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div  v-if=" ! $loadingRouteData">
        <div class="panel-body">
            <div id="alerts" v-if="messages.length > 0">
                <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                    {{ trans('message.message') }}
                </div>
            </div>
           <schedule :model.sync="screen"></schedule>
        </div>
    </div>
</template>

<script>
    module.exports = {

        components: {
            Schedule: require('./../../components/Schedule.vue')
        },

        data: function () {
            return {
                screen: {
                },
                messages: []
            }
        },

        methods: {
            // Let's fetch the screen
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/screens/' + id }).then(
                        function (response) {
                            that.$set('screen', response.entity.data)
                           successHandler(response.entity.data)
                        },
                        function (response, status, request) {
                            // Go tell your parents that you've messed up somehow
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
                            self.messages = []
                            self.messages.push({type: 'success', message: self.trans('screen.updated')})
                        },
                        function (response) {
                            self.messages = []
                            for (var key in response.entity) {
                                self.messages.push({type: 'danger', message: response.entity[key]})
                            }
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