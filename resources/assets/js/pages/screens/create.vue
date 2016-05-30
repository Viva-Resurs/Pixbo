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

<script>
    module.exports = {
        props: ['options'],

        data() {
            return {
                messages: [],
                durpzone: null,
            }
        },

        computed: {
            action() {
                if(this.options !== undefined) {
                    return this.options.action !== undefined ? this.options.action : '/api/screens'
                }
                return '/api/screens'
            },
            redirect() {
                if(this.options !== undefined) {
                    return this.options.redirect !== undefined ? this.options.redirect : '/screens'
                }
                return '/screens'
            }
        },

        methods: {
            initDropzone: function () {
                self = this
                var vm = this
                self.$nextTick(function () {
                    new Dropzone("#my-dropzone", {
                        maxFileSize: 10,
                        acceptedFiles: '.jpg,.jpeg,.png,.bmp',
                        dictDefaultMessage: vm.trans('screen.upload_message'),
                        init: function () {
                            var self = this;

                            // -------- bind events -------- //

                            //New file added
                            self.on("addedfile", function (file) {
                                console.log('new file added ', file);
                            });

                            // Send file starts
                            self.on("sending", function (file, xhr, formData) {
                                if (localStorage.getItem('jwt-token'))
                                    xhr.setRequestHeader('Authorization', localStorage.getItem('jwt-token'))
                            });

                            self.on("success", function () {
                                vm.$dispatch('alert', {
                                    message: vm.trans('screen.uploaded'),
                                    options: {theme: 'success'}
                                })
                                // TODO: Might want to route to the newly created screen instead of it's 'parent'
                                // the API needs to send back the ID of the new screen.
                                vm.$route.router.go(vm.redirect)
                            });
                        }
                    })
                })
            }
        }

    }
</script>