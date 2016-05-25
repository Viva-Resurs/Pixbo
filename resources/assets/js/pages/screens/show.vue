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
    import Schedule from '../../components/Schedule.vue'
    export default {

        components: { Schedule },

        data: function () {
            return {
                screen: {}
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