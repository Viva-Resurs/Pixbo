// browserify entrypoint
var Vue = require('vue');

window.Vue = Vue;
Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
var bootstrap = require('bootstrap-sass');


import Schedule from './components/Schedule.vue';
import ScreenList from './components/ScreenList.vue';

Vue.config.debug = true

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
            lang: null,
        };
    },

    methods: {
        addAlert: function(toast) {
            vueboot.toastService.create(toast);
        },
        trans: function (string) {
            var scope = string.split('.')[0];
            var word = string.split('.')[1];

            if (this.lang && this.lang[scope] && this.lang[scope][word])
                return this.lang[scope][word];
            else
                return string; // Fallback
        },
        trans_choice: function(string, num) {
            var scope = string.split('.')[0];
            var word = string.split('.')[1];
            
            if (this.lang && this.lang[scope] && this.lang[scope][word])
                return this.lang[scope][word].split('|')[num];
            else
                return string; // Fallback
        }
    },

    events: {
        'add-alert': function(toast) {
            vueboot.toastService.create(toast);
        },
        'trans': function (string) {
            return this.trans(string);
        },
        'trans_choice': function (string) {
            return this.trans_choice(string);
        }
    },
    ready: function() {
        this.$http.get('/api/locales', function(locale) {
            this.lang = locale;
        }.bind(this));
    }
});