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
                <div class="form-group" v-if="!changeScreen">
                    <label for="originalfilename" class="model_label">
                        {{ trans('general.file') }}
                    </label>

                    <div class="model_input">
                        <input value="{{ (screen.photo) ? screen.photo.originalName : '' }}" type="text" name="originalfilename" class="form-control">
                        <span class="input-group-addon btn btn-default" @click="changeScreen = true">
                            <span class="fa fa-picture-o"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group" v-else>
                    <div id="dropzone">
                        <form class="dropzone" :action="action" id="my-dropzone" v-dropzone></form>
                    </div>
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
                screen: {},
                changeScreen: false
            }
        },

        computed: {

            action() {

                if(this.options !== undefined)
                    return this.options.action !== undefined ? this.options.action : '/api/screens';

                return '/api/screens/' + this.screen.id;

            }

        },

        methods: {

            initDropzone() {

                var vm = this;

                vm.$nextTick(function () {

                    vm.durpzone = $("#my-dropzone").dropzone({
                        maxFileSize: 10,
                        uploadMultiple: false,
                        maxFiles: 1,
                        acceptedFiles: '.jpg,.jpeg,.png,.bmp',
                        dictDefaultMessage: vm.trans('screen.upload_message'),
                        init: function () {

                            var self = this;

                            self.on("sending", function (file, xhr, formData) {
                                
                                if (localStorage.getItem('jwt-token'))
                                    xhr.setRequestHeader('Authorization', localStorage.getItem('jwt-token'));

                                if ( vm.$root.history.previous == 'screengroups.show' )
                                    formData.set('screengroups',vm.$root.history.params.id);

                            });

                            self.on("success", function (response) {
                                
                                vm.$dispatch('alert', {
                                    message: vm.trans('screen.uploaded'),
                                    options: {theme: 'success'}
                                });

                                vm.$dispatch('refresh-thumb',vm.$route.params.id);
                                
                                setTimeout(function(){
                                    vm.fetch(vm.$route.params.id);
                                    vm.changeScreen = false;    
                                },2000);

                            });

                        }
                    });

                });

            }

        },

        route: {
            data: function (transition) {
                client({ path: '/screens/' + this.$route.params.id }).then(
                    function (response) {
                        transition.next({screen: response.entity.data});
                    },
                    function (response){
                        transition.next();
                        console.error(response.entity.error);
                    }
                );
            }
        }

    }
</script>
