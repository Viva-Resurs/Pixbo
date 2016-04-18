<template>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-sm-6 col-md-3" v-for="screen in list">
                <screen v-bind:data="screen" v-bind:association="url"></screen>
            </div>
        </div>
    </div>

</template>

<script>
    import Screen from './Screen.vue';
    import Modal from './Modal.vue';

    export default {

    props: ['url'],

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
            if(this.url == null || this.url == '') {
                this.$http.get('/api/screens', function (screens) {
                    this.list = screens;
                }.bind(this));
            } else {
                this.$http.get(this.url, function (screens) {
                    this.list = screens;
                }.bind(this));
            }
        },
    },
    ready: function() {
        this.fetch_screens();
    },

    computed: {

    },
};
</script>