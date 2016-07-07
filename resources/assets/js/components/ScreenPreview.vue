<template>

    <div>
        <img id="ScreenPreviewThumb" class="img-thumbnail" width="100%" @click="showModal = true">
    </div>

    <modal :show.sync="showModal" backdrop="true" width="90%">
        <div slot="modal-header"></div>
        <div slot="modal-body" class="modal-body">
            <img style="margin: auto auto;" id="ScreenPreview" class="img-responsive" @click="showModal = false">
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
                showModal: false
            }
        },

        methods: {

            fetch(id) {

                var self = this;

                client({ path: '/screens/' + id }).then(

                    function (response) {

                        self.$set('screen', response.entity.data);
                        self.setThumb();

                    },

                    function (response) {
                        
                        console.log(response);

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
