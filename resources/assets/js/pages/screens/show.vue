<template>

    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <schedule :model.sync="screen">
                <div slot="model_specific_setting">
                    <model-selector :selected.sync="screen.category"
                                    model="category"
                    ></model-selector>
                </div>
            </schedule>
            
        </div>

    </div>

</template>

<script>
    import Schedule from '../../components/Schedule.vue'
    import ModelSelector from '../../components/ModelSelector.vue'
    export default {

        components: { Schedule, ModelSelector },

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