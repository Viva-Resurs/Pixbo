<template>
    <div class="screen_gallery">
        <ul v-for="screen in screens">
            <li class="screen_gallery__entity">
                <a href="/admin/screens/{{ $element->id }}/edit">
                    <img src="/{{ $element->photo->thumb_path }}" alt="">
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['screengroup_id'],

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
                this.$http.post('screens/remove/' + screen.id, screen);
            }
        }
    };
</script>