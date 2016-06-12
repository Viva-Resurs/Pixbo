<template>
    <div>
        <nav-component></nav-component>
        <toaster></toaster>
        <router-view></router-view>
        <footer-component></footer-component>
    </div>
</template>

<script>
    import Toaster from './components/Toaster.vue'
    import { store } from './store'
    import Auth from './mixins/Auth.vue'

    export default {

        components: { Toaster },
        mixins: [Auth],

        data() {
            return {
                history: {
                    previous: null,
                    params: null
                }
            }
        }
    }
</script>