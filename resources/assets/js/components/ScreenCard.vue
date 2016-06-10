<template>
    <div class="screencard">
        <div class="screencard_content">
            <img class="screencard_img" :src="'/' + screen.photo.thumb_path">

            <div class="screencard_tools" role="group">
                <a class="btn btn-info btn-lg" v-link="{ path: '/screens/'+screen.id }">
                    <span class="fa fa-calendar" v-tooltip data-original-title="{{ trans('screen.edit') }}"></span>
                </a>

                <a class="btn btn-danger btn-lg" v-on:click="deleteScreen()">
                    <template v-if="this.from=='screengroup'">
                        <span class="fa fa-minus" v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></span>
                    </template>
                    <template v-else>
                        <span class="fa fa-times" v-tooltip data-original-title="{{ trans('general.delete') }}"></span>
                    </template>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['screen', 'index', 'from'],

        methods: {
            deleteScreen() {
                this.$dispatch('remove-screen', this.index)
            },
        }
    }
</script>

<style>
    .ScreenCard__buttons {
        position: absolute;
        top: 0%;
        left: 100%;
        margin-left: -52px;
    }
</style>