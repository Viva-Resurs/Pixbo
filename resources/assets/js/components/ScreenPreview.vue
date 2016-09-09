<template>

    <div v-if="loading">
        <loadingthumb></loadingthumb>
    </div>



    <div class="{{(loading) ? 'hidden' : ''}}">
<span class="errorthumb fa-stack fa-5x" v-if="errorthumb">
  <i class="fa fa-file-image-o fa-stack-1x"></i>
  <i class="fa fa-exclamation fa-stack-1x text-danger"></i>
</span>

        <img id="ScreenPreviewThumb" class="img-thumbnail" style="cursor:zoom-in" width="100%" @click="showModal = true">
    </div>



    <modal :show.sync="showModal" backdrop="true" width="90%">
        <div slot="modal-header"></div>
        <div slot="modal-body" class="modal-body">
            <img style="margin: auto auto; cursor:zoom-out" id="ScreenPreview" class="img-responsive" @click="showModal = false">
        </div>
        <div slot="modal-footer"></div>
    </modal>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'ScreenPreview',

        components: {
            'modal': VueStrap.modal
        },

        props: [ 'id' ],

        data: function () {
            return {
                screen: {},
                showModal: false,
                errorthumb: false,
                loading: true
            }
        },

        methods: {

            fetch(id) {

                var self = this;

                self.loading = true;

                client({ path: '/screens/' + id }).then(

                    function (response) {

                        self.loading = false;

                        self.$set('screen', response.entity.data);

                        self.setThumb();

                    },

                    function (response) {
                        
                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.loading = false;

                    }

                );

            },

            setThumb() {

                if (!this.screen.photo || !this.screen.photo.thumb_path)
                    return this.errorthumb = true;
                else
                    this.errorthumb = false;

                $('#ScreenPreviewThumb').attr('src',this.screen.photo.thumb_path);
                $('#ScreenPreview').attr('src',this.screen.photo.path);

            }

        },

        created: function() {
            this.fetch(this.id);
            
            var self = this;
            
            this.$on('refresh-thumb', function (id) {
                self.fetch(id);
            });
        }

    }
</script>
