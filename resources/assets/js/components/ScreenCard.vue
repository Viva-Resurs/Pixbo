<template>

    <div class="screencard">

        <div class="screencard_content">

            <div v-if="screen.photo && screen.photo.thumb_path">
                <img :src="'/' + screen.photo.thumb_path"
                    class="screencard_img {{(screen.screengroups.length<1 || screen.category==1)?'inactive':''}}">
            </div>
            <div class="screencard_error" v-else>
                <span v-else class="fa-stack fa-5x">
                    <i class="fa fa-file-image-o fa-stack-1x"></i>
                    <i class="fa fa-exclamation fa-stack-1x text-danger"></i>
                </span>
            </div>

            <div class="screencard_tools" role="group">
                <a class="btn btn-info btn" v-link="{ path: '/screens/'+screen.id }">
                    <span class="fa fa-calendar" v-tooltip data-original-title="{{ trans('screen.edit') }}"></span>
                </a>

                <template v-if="from=='screen' || from=='screengroup'">
                    <a class="btn btn-info hover-danger btn" v-on:click="deleteScreen(screen.id)">
                        <template v-if="from=='screengroup'">
                            <span class="fa fa-minus" v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></span>
                        </template>
                        <template v-else>
                            <span class="fa fa-times" v-tooltip data-original-title="{{ trans('general.delete') }}"></span>
                        </template>
                    </a>
                </template>
                <template v-else>
                    <a v-if="screen.category!=1" class="btn btn-info hover-danger btn-xs" v-on:click="deleteScreen()">
                        <span class="fa fa-minus" v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></span>
                    </a>
                </template>
            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'ScreenCard',

        props: [ 'screen', 'from' ],

        methods: {
            deleteScreen(id) {
                this.$dispatch('remove-screen', this.id);
            }
        }

    }
</script>
