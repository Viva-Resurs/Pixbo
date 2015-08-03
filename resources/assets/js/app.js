var Vue = require('vue');
var bootstrap = require('bootstrap-sass');

new Vue({
    el: '#app',

    filters: {
        reverse: require('./filters/reverse')
    }
});