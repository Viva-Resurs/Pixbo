<template>
    <div class="panel-heading">
        {{ trans('screen.upload') }}
    </div>
    <div class="panel-body">
        <div id="dropzone">
            <form class="dropzone" action="/api/screens" id="my-dropzone" v-dropzone></form>
        </div>
    </div>
</template>

<script>
    module.exports = {

        data() {
            return {
                messages: [],
                durpzone: null,
            }
        },
        methods: {
            trans_helper(text) {
                return this.trans(text)
            },
            initDropzone: function () {
                self = this
                var vm = this
                self.$nextTick(function () {
                    new Dropzone("#my-dropzone", {
                        maxFileSize: 10,
                        acceptedFiles: '.jpg,.jpeg,.png,.bmp',
                        dictDefaultMessage: vm.trans_helper('screen.upload_message'),
                        init: function () {
                            var self = this;
                            // config
                            //self.options.addRemoveLinks = true;
                            //self.options.dictRemoveFile = "Delete";


                            // bind events

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
                                // TODO: This one should redirect to the newly created screen,
                                // the API needs to send back the ID of the new screen.
                                vm.$route.router.go('/screens')
                            });
                        }
                    })
                })
            }
        }

    }
</script>