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

                    <div class=" model_input">
                        <input value="{{screen.photo.originalName}}" type="text" name="originalfilename" class="form-control">
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

            },

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

                            // -------- bind events -------- //

                            // Send file starts
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

        created: function(){
            this.fetch(this.$route.params.id);
        }

    }
</script>
