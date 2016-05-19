/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <!-- TODO: Fix the styling of things-->
    <screen-list :screens="screens"></screen-list>
</template>

<script type="text/ecmascript-6">
    import ScreenList from '../../components/ScreenList.vue'
    export default {
        props: ['screens'],
        components: { ScreenList },

        methods: {
            // TODO remove association here
        },

        ready() {
            // Event listener for 'remove-screen'
        }
    }
</script>