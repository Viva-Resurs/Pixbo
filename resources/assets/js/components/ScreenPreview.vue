<template>

    <div v-if="loading">
        <loadingthumb></loadingthumb>
    </div>

    <div :class="(loading) ? 'hidden' : 'previewthumb'">
        <div v-if="errorthumb" class="errorthumb">
            <span class="fa-stack fa-5x">
                <i class="fa fa-file-image-o fa-stack-1x"></i>
                <i class="fa fa-exclamation fa-stack-1x text-danger"></i>
            </span>
        </div>
        <img v-if="!errorthumb" class="img-thumbnail"
            :src.sync="photo.thumb_path"
            @click="showModal = true">
    </div>

    <modal :show.sync="showModal">
        <div slot="modal-header"></div>
        <div slot="modal-body" class="modal-body">
            <img class="img-responsive previewmodal"
                :src.sync="photo.path"
                @click="showModal = false">
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
        data: function() {
            return {
                photo: false,
                showModal: false,
                errorthumb: false,
                loading: true
            }
        },
        methods: {
            setThumb(photo) {
                if (!photo || !photo.thumb_path)
                    return this.errorthumb = true;
                else
                    this.errorthumb = false;
                this.photo = photo;
                this.loading = false;
            }
        },
        created: function() {
            this.$on('refresh_photo', () => this.loading=true );
            this.$on('image_updated', this.setThumb);
        },
        destroy: function() {
            this.$off('refresh_photo')
            this.$off('image_updated')
        }
    }
</script>
