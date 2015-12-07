<style type="text/scss">
    .screen_gallery {

    }
    .screen_gallery__entity {

    }
</style>



<template>
    <ul class="screen_gallery">
        <li v-for="screen in screens" class="screen_gallery__entity">
            <a href="/admin/screens/{{ screen.id }}/edit">
                <img v-bind:src="'/' + screen.photo.thumb_path" alt="">
            </a><button @click="removeScreen(screen)">x</button>
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
            removeScreen: function (screen) {
                this.screens.$remove(screen);
                this.$http.post('screens/' + screen.id + '/remove_association' , screen);
            },
            editScreen: function (screen) {

            }
        }
    };
</script>