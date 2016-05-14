<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if=" screens.length == 0 ">
            {{ trans('screen.empty') }}
        </div>

        <div v-if=" screens.length > 0 ">
            <div class="row">
                <div v-for="screen in screens">
                    <screen-card :screen="screen"></screen-card>
                </div>
                </ul>
            </div>
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
                screens: []
            }
        },

        methods: {
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
