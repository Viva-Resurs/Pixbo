<template>

    <div class="screencard">

        <div class="screencard_content">

            <img :src="'/' + ((screen.photo) ? screen.photo.thumb_path : '')"
                class="screencard_img {{(screen.screengroups.length<1 || screen.category==1)?'inactive':''}}">

            <div class="screencard_tools" role="group">
                <a class="btn btn-info btn-lg" v-link="{ path: '/screens/'+screen.id }">
                    <span class="fa fa-calendar" v-tooltip data-original-title="{{ trans('screen.edit') }}"></span>
                </a>

                <template v-if="from=='screen' || from=='screengroup'">
                    <a class="btn btn-danger btn-lg" v-on:click="deleteScreen(screen.id)">
                        <template v-if="from=='screengroup'">
                            <span class="fa fa-minus" v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></span>
                        </template>
                        <template v-else>
                            <span class="fa fa-times" v-tooltip data-original-title="{{ trans('general.delete') }}"></span>
                        </template>
                    </a>
                </template>
                <template v-else>
                    <a v-if="screen.category!=1" class="btn btn-danger btn-lg" v-on:click="deleteScreen()">
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
