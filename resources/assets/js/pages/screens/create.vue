<template>

    <div class="panel-heading">
        {{ trans('screen.upload') }}
    </div>

    <div class="panel-body">

        <div id="dropzone">
            <form class="dropzone" :action="action" id="my-dropzone" v-dropzone></form>
        </div>

    </div>
    
</template>

<script type="text/ecmascript-6">
    export default {

        name: 'Create',

        props: [ 'options' ],

        data: function() {
            return {
                messages: [],
                durpzone: null,
            }
        },

        computed: {

            action() {

                if(this.options !== undefined)
                    return this.options.action !== undefined ? this.options.action : '/api/screens';

                return '/api/screens';

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

                                vm.$route.router.go({ path: '/screens/'+response.xhr.response, query: { screengroup: vm.$root.history.params.id } });

                            });

                        }
                    });

                });

            }

        }

    }
</script>
