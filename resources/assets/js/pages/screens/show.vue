<template>

    <div class="panel-heading">
        {{ trans('screen.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <schedule :model.sync="screen" :selected_categories.sync="selected_categories">
            <div slot="model_specific_setting">
                <div class="form-group">
                    <model-selector :selected.sync="selected_categories"
                                    model="category"
                                    classes="model_input"
                                    multiple="true"
                                    mode="count > 3"
                    >
                        <div slot="label">
                            <label for="screen_category" class="model_label">
                                {{ trans('category.select') }}
                            </label>
                        </div>
                    </model-selector>
                </div>
                <div class="form-group">
                    <label for="originalfilename" class="model_label">
                        {{ trans('general.file') }}
                    </label>

                    <div class="model_input">
                        <input type="text" name="originalfilename" class="form-control"
                            readonly
                            :value.sync="screen.photo.originalName"  >
                        <span class="input-group-addon btn btn-default"
                            @click="changeScreen = !changeScreen">
                            <span v-if="changeScreen" class="fa fa-undo"></span>
                            <span v-else class="fa fa-picture-o"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group" v-if="changeScreen">
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
        data: function() {
            return {
                screen: {},
                selected_categories: [],
                changeScreen: false
            }
        },
        computed: {
            action() {
                if (this.options !== undefined && this.options.action !== undefined)
                    return this.options.action;
                return '/api/screens/' + this.screen.id;
            }
        },
        methods: {
            refreshPhoto(id) {
                this.loading = true;
                client({ path: '/screens/' + id }).then(
                    (response) => {
                        var photo = response.entity.data.photo
                        this.$set('screen.photo', photo);
                        this.$dispatch('image_updated', photo);
                    },
                    (response) => {
                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);
                        this.loading = false;
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
                                vm.$dispatch('refreshing_photo');
                                vm.refreshPhoto(vm.$route.params.id)
                                setTimeout(function(){
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
                    (response) => {
                        transition.next({screen: response.entity.data});
                        this.$dispatch('image_updated', response.entity.data.photo);
                    },
                    (response) => {
                        transition.next();
                        console.error(response.entity.error);
                    }
                );
            }
        }
    }
</script>
