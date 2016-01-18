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



new Vue({
    el: '#app',

    components: {
        'Alert': Alert,
        'screengallery': ScreenGallery,
        'Tickers': Ticker,
        'Screen': Screen
    },

    data: function () {
        return {
            alerts: [],
        };
    },

    methods: {
        AddAlert: function(message, type) {

        }
    }
});
