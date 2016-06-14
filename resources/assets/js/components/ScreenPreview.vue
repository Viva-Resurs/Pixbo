<template>

    <div >

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

<script>
    export default {

        components: {
            'modal': VueStrap.modal
        },
        props: ['id'],

        data: function () {
            return {
                screen: {},
                showModal: false
            }
        },

        methods: {
            fetch: function (id) {
                var that = this
                client({ path: '/screens/' + id }).then(
                    function (response) {
                        that.$set('screen', response.entity.data)
                        that.setThumb();
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut')
                        }
                    }
                )
            },
            setThumb: function(){
                $('#ScreenPreviewThumb').attr('src',this.screen.photo.thumb_path);
                $('#ScreenPreview').attr('src',this.screen.photo.path);
            }
        },

        created() {
            this.fetch(this.id);
        }
    }
</script>