<template>
    <div class="screencard">
        <div class="screencard_content">
            <img class="screencard_img" :src="'/' + screen.photo.thumb_path">

            <div class="screencard_tools" role="group">
                <a class="btn btn-info btn-lg" v-link="{ path: '/screens/'+screen.id }">
                    <span class="fa fa-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Planera"></span>
                </a>
                <a class="btn btn-danger btn-lg" v-on:click="deleteScreen($index)">
                    <span class="fa fa-times" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Ta bort"></span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['screen', 'parent'],

        // TODO: Add actual remove calls!

        methods: {
            deleteScreen(screen) {
                if(!typeof(this.parent) == 'undefined') {
                  console.log('remove association')
                }  else {
                  console.log('remove for realz')
                }
            },
        }
    }
    /*
     deleteScreen: function (index) {
     var that = this
     client({ path: '/screens/' + this.screens[index].id, method: 'DELETE' }).then(
     function (response) {
     that.screens.splice(index, 1)
     that.$dispatch('alert', {
     message: that.trans('screen.deleted'),
     options: {theme: 'success'}
     })
     },
     function (response) {
     that.$dispatch('alert', {
     message: that.trans('screen.deleted_fail'),
     options: {theme: 'error'}
     })
     }
     )
     }

     */
</script>

<style>
    .ScreenCard__buttons {
        position: absolute;
        top: 0%;
        left: 100%;
        margin-left: -52px;
    }
</style>