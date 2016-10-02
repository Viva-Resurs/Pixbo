// browserify entrypoint
var Vue = require('vue');

Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
var bootstrap = require('bootstrap-sass');

Vue.config.debug = true

// Init sessionStorage-handler
window.PixboStorage = require('./components/SessionStorageHandler.vue');

// Import global-mixins
Vue.mixin(require('./components/Translation.vue'));

window.Vue = new Vue({
    
    el: '#app',

    components: {
        'Alert': vueboot.alert,
        'Toast': vueboot.toast,
        'Schedule'  : require('./components/Schedule.vue'),
        'ScreenList': require('./components/ScreenList.vue'),
    },

    data: function () {
        return {
            show: false,
        };
    },

    methods: {
        addAlert: function(toast) {
            vueboot.toastService.create(toast);
        },
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

    created: function() {
        window.PixboStorage.Load();
            this.$http.get('/api/locales', function(locale) {
                window.PixboStorage.Set('lang',locale); // Update Lang-Data
            });
    },

});