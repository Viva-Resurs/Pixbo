<template>

    <div v-if="loading">
        <loadingthumb></loadingthumb>
    </div>

    <div class="{{(loading) ? 'hidden' : ''}}">
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

                $('#ScreenPreviewThumb').attr('src',this.screen.photo.thumb_path);
                $('#ScreenPreview').attr('src',this.screen.photo.path);

            }

        },

        created: function() {
            this.fetch(this.id);
        }

    }
</script>
