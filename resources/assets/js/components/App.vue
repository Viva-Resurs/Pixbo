<template>
    <div>
        <nav class="navbar navbar-default">
            <div class="container">
                <!--

                -->
                <navs></navs>
            </div>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Navs from './nav/Navs.vue';
    export default {
        components: {
            Navs
        }
    }
</script>