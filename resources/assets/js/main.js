// browserify entrypoint
var Vue = require('vue');
Vue.use(require('vue-resource'));
var bootstrap = require('bootstrap-sass');

import Alert from './components/Alert.vue';
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
    }
});