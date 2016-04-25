<template>
    <div class="col-sm-6 col-md-3">
        <div class="thumbnail screens_card row">
            <div class="col-lg-12">
                <div class="row">
                    <img class="screens_card__img" src="/{{ screen.photo.thumb_path }}" style="width:100%;height:auto;">

                    <div class="btn-group-vertical ScreenCard__buttons pull-right" role="group">
                        <a class="btn btn-primary btn-xs" v-link="{ path: '/screens/'+screen.id }">Ändra</a>
                        <a class="btn btn-primary btn-xs" v-on:click="deleteScreen($index)">Ta bort</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['screen', 'parent'],

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
</script>

<style>

</style>