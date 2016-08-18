<template>

    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

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

</template>

<script type="text/ecmascript-6">
    import Schedule from '../../components/Schedule.vue'
    import ModelSelector from '../../components/ModelSelector.vue'

    export default {

        name: 'Show',

        components: { Schedule, ModelSelector },

        data: function () {
            return {
                screen: {}
            }
        },

        methods: {

            fetch(id) {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/screens/' + id }).then(

                    function (response) {

                        self.$set('screen', response.entity.data);

                        self.$loadingRouteData = false;

                        if ( self.$route.query.screengroup )
                            self.screen.screengroups.push( { id: self.$route.query.screengroup });
                        
                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                    }

                );

            }

        },

        created: function(){
            this.$loadingRouteData = true;
            this.fetch(this.$route.params.id);
        }

    }
</script>
