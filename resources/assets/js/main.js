// browserify entrypoint
var Vue = require('vue');

window.Vue = Vue;
Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
var bootstrap = require('bootstrap-sass');

import Schedule from './components/Schedule.vue';
import ScreenList from './components/ScreenList.vue';



window.vue_instance = new Vue({
    el: '#app',
    components: {
        'Alert': vueboot.alert,
        'Toast': vueboot.toast,
        Schedule,
        ScreenList,

    },

    data: function () {
        return {
            show: false,
            lang: [],
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
        this.lang = new Object;

            this.$http.get('/api/locales', function(locale) {
                this.lang = locale;
            }.bind(this));
    }
});