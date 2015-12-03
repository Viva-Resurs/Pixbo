// browserify entrypoint
var Vue = require('vue');
Vue.use(require('vue-resource'));
var bootstrap = require('bootstrap-sass');

import Alert from './components/Alert.vue';

new Vue({
    el: '#app',

    components: { Alert }
});