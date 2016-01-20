// browserify entrypoint
var Vue = require('vue');
Vue.use(require('vue-resource'));
//Vue.use(require('vue-strap'));
var bootstrap = require('bootstrap-sass');
//var vue_strap = require('vue-strap');



//import Alert from './components/Alert.vue';
import Alert from './components/Alert.vue';
//var alert = require('vue-strap');//src/alert');
import ScreenGallery from './components/ScreenGallery.vue';
import Ticker from './components/Ticker.vue';
import Screen from './components/Screen.vue';

var vueboot = require('vueboot');



new Vue({
    el: '#app',

    components: {
        //'Alert': Alert,
        'screengallery': ScreenGallery,
        'Tickers': Ticker,
        'Screen': Screen,
        'Alert': vueboot.alert,
        'Toast': vueboot.toast,
    },

    data: function () {
        return {
            show: false,
        };
    },

    methods: {
        AddAlert: function(toast) {
            vueboot.toastService.create(toast);
        }
    },

    events: {
        'add-alert': function(toast) {
            vueboot.toastService.create(toast);
        }
    }
});
