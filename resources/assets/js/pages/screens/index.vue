<template>
    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if=" ! $loadingRouteData && screens.length == 0">
        {{ trans('screen.empty') }}
    </div>

    <div  v-if=" ! $loadingRouteData && screens.length > 0">
        <div class="row">
            <div  v-for="screen in screens">
                <screen-card :screen="screen"></screen-card>
            </div>
            </ul>
        </div>
    </div>
</template>

<script>
    module.exports = {

        components: {
            ScreenCard: require('../../components/ScreenCard.vue')
        },

        data: function () {
            return {
                screens: [],
                messages: []
            }
        },

        methods: {
            // Let's fetch some dogs
            fetch: function (successHandler) {
                var that = this
                client({ path: '/screens' }).then(
                        function (response) {
                            that.$set('screens', response.entity.data)
                            successHandler(response.entity.data)
                        },
                        function (response, status) {
                            if (_.contains([401, 500], status)) {
                                that.$dispatch('userHasLoggedOut')
                            }
                        }
                )
            },

            deleteScreen: function (index) {
                var that = this
                client({ path: '/screens/' + this.screens[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.screens.splice(index, 1)
                            that.messages = [{type: 'success', message: that.trans('screen.deleted')}]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: that.trans('screen.deleted_fail')})
                        }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screens: data})
                })
            }
        }

    }
</script>
