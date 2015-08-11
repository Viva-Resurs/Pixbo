var Vue = require('vue');
Vue.use(require('vue-resource'));
var bootstrap = require('bootstrap-sass');

Vue.component('demo-grid', {
  template: '#grid-template',
  replace: true,
  props: ['data', 'columns', 'filter-key'],
  data: function () {
    return {
      data: null,
      columns: null,
      sortKey: '',
      filterKey: '',
      reversed: {}
    }
  },
  compiled: function () {
    // initialize reverse state
    var self = this
    this.columns.forEach(function (key) {
      self.reversed.$add(key, false)
    })
  },
  methods: {
    sortBy: function (key) {
      this.sortKey = key
      this.reversed[key] = !this.reversed[key]
    }
  }
})

// bootstrap the demo
var demo = new Vue({
  el: '#demo',
  data: {
    searchQuery: '',
    gridColumns: ['id', 'name', 'mac_address'],
    gridData: [
    ]
  },
  ready: function() {
        this.fetchClients();
    },
    methods: {
        fetchClients: function() {
            this.$http.get('/clients', function(clients) {
            this.$set('gridData', clients);
            });
        }
    }
});
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