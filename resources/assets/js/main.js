window.Vue = require('vue');
window.VueRouter = require('vue-router');

Vue.use(require('vue-resource'));
Vue.config.debug = true;
Vue.http.options.root = '/api';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');

var router = new VueRouter({
    history: true,
    root: 'app'
});

var bootstrap = require('bootstrap-sass');

new Vue({
    el: '#app',
    components: {

    },
    data: function () {
        return {

        };
    },
    methods: {

    },
    events: {

    },
    computed: {

    },
    ready: function () {

    },
    created: function () {

    },
});