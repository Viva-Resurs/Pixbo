// browserify entrypoint
var Vue = require('vue');
window.Vue = Vue;
Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
//Vue.use(require('vue-strap'));
var bootstrap = require('bootstrap-sass');
//var vue_strap = require('vue-strap');



//import Alert from './components/Alert.vue';
import Alert from './components/Alert.vue';
//var alert = require('vue-strap');//src/alert');
import ScreenGallery from './components/ScreenGallery.vue';
import Ticker from './components/Ticker.vue';
import Schedule from './components/Schedule.vue';





window.vue_instance = new Vue({
    el: '#app',

    components: {
        //'Alert': Alert,
        'screengallery': ScreenGallery,
        'Tickers': Ticker,
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
