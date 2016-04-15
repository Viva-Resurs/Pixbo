<template>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-sm-6 col-md-3" v-for="screen in list">
                <screen v-bind:data="screen"></screen>
            </div>
        </div>
    </div>

</template>

<script>
    import Screen from './Screen.vue';
    import Modal from './Modal.vue';

    export default {

    //props: ['list'],

    components: {
        Screen,
        Modal,
    },

    data: function() {
        return {
            list: [],
        };
    },

    methods: {
        fetch_screens: function() {
            this.$http.get('/api/screens', function(screens) {
                this.list = screens;
            }.bind(this));
        },
    },
    ready: function() {
        this.fetch_screens();
    },

    computed: {

    },
};
</script>