<template>

    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <schedule :model.sync="screen">
                <div slot="model_specific_setting">
                    <div class="form-group">
                        <model-selector :selected.sync="screen.category"
                                        model="category"
                                        classes="model_input"
                        >
                            <div slot="label">
                                <label for="screen_category" class="model_label">
                                    {{ trans('category.select') }}
                                </label>
                            </div>
                        </model-selector>
                    </div>
                    <hr>
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
                var self = this
                client({ path: '/screens/' + id }).then(
                    function (response) {
                        self.$set('screen', response.entity.data)

                        if ( self.$route.query.screengroup )
                            self.screen.screengroups.push( { id: self.$route.query.screengroup });
                        
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