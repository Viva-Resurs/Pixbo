<style type="text/scss">
    .screen_gallery {

    }
</style>



<template>
    <ul v-for="screen in screens" class="screen_gallery">
        <li class="screen_gallery__entity">
            <a href="/admin/screens/{{ screen.id }}/edit">
                <img v-bind:src="'/' + screen.photo.thumb_path" alt="">
            </a>
        </li>
    </ul>
</template>

<script>
    export default {

        data: function () {
            return {
                screens: []
            };
        },

        ready: function () {
            this.$http.get('screens', function(screens) {
                this.screens = screens;
            }.bind(this));
        },

        methods: {
            remove_screen: function (screen) {
                this.list.$remove(screen);
                this.$http.post('screens/' + screen.id + '/remove' , screen);
            }
        }
    };
</script>