// browserify entrypoint
var Vue = require('vue');
//import Vue from 'vue';

window.Vue = Vue;
Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
var bootstrap = require('bootstrap-sass');



//import Alert from './components/Alert.vue';
//import Alert from './components/Alert.vue';
//var alert = require('vue-strap');//src/alert');
//import ScreenGallery from './components/ScreenGallery.vue';
//import Ticker from './components/Ticker.vue';
import Schedule from './components/Schedule.vue';
import Tags from './components/Tags.vue';



window.vue_instance = new Vue({
    el: '#app',
/*
    http: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    },
*/
    components: {
        //'Alert': Alert,
        //'screengallery': ScreenGallery,
        //'Tickers': Ticker,
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