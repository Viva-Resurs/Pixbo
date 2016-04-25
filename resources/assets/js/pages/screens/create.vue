<template>
    <div class="panel-heading">
        Ladda upp bild
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
        <div id="dropzone">
        <form class="dropzone" action="/api/screens" id="my-dropzone" v-dropzone>
        </form>
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
            initDropzone: function () {
                self = this
                var vm = this
                self.$nextTick(function () {
                    new Dropzone("#my-dropzone", {
                        maxFileSize: 10,
                        acceptedFiles: '.jpg,.jpeg,.png,.bmp',
                        dictDefaultMessage: 'Bläddra efter bild, eller släpp bild här.',
                        init: function () {
                            var self = this;
                            // config
                            self.options.addRemoveLinks = true;
                            self.options.dictRemoveFile = "Delete";


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
                                vm.messages = [ {type: 'success', message: 'Bilden har laddats upp'} ]
                            });
                        }
                    })
                })
            }
        }

    }
</script>