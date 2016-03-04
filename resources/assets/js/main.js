// browserify entrypoint
var Vue = require('vue');

window.Vue = Vue;
Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
var bootstrap = require('bootstrap-sass');

import Schedule from './components/Schedule.vue';
import Tags from './components/Tags.vue';



window.vue_instance = new Vue({
    el: '#app',
    components: {
        'Schedule': Schedule,
        'Alert': vueboot.alert,
        'Toast': vueboot.toast,

    },

    data: function () {
        return {
            show: false,
        };
    },

    methods: {
        addAlert: function(toast) {
            vueboot.toastService.create(toast);
        }
    },

    events: {
        'add-alert': function(toast) {
            vueboot.toastService.create(toast);
        }
    },
    ready: function() {
        var vm = this;
    }
});