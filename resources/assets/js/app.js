var Vue = require('vue');
Vue.use(require('vue-resource'));
var bootstrap = require('bootstrap-sass');



/*
new Vue({
    el: '#client',

    ready: function() {
        this.fetchClients();
    },

    methods: {
        fetchClients: function() {
            this.$http.get('/clients', function(clients) {
            this.$set('clients', clients);
            });
        }
    }
});
*/