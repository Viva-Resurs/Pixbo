<template>

    <div>
        <nav-component></nav-component>
        <toaster></toaster>
        <router-view v-show="!errors"></router-view>
        <error404 v-show="errors"></error404>
        <footer-component></footer-component>
    </div>

</template>

<script type="text/ecmascript-6">
    import Toaster from './components/Toaster.vue'
    import { store } from './store'
    import Auth from './mixins/Auth.vue'
    import error404 from './pages/404.vue'

    export default {

        components: { Toaster, error404 },

        mixins: [ Auth ],

        data: function() {
            return {
                history: {
                    previous: null,
                    params: null
                },
                errors: false
            }
        },

        created: function(){
            this.$on('alert', function (args) {
                this.$broadcast('alert', args);
            })
        }

    }
</script>
