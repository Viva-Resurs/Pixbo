<template>
  <table class="table table-striped">
    <thead>
      <tr>
        <th v-repeat="key: columns"
        v-on="click:sortBy(key)"
        v-class="active: sortKey == key">
        @{{key | capitalize}}
        <span class="arrow"
        v-class="reversed[key] ? 'dsc' : 'asc'">
      </span>
    </th>
  </tr>
</thead>
<tbody>
  <tr v-repeat="
  entry: data
  | filterBy filterKey
  | orderBy sortKey reversed[sortKey]">
  <td v-repeat="key: columns">
    @{{entry[key]}}
  </td>
</tr>
</tbody>
</table>
</template>

<script>

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
  el: '#app',
  data: {
    searchQuery: '',
    gridColumns: ['id', 'name', 'actions'],
    gridData: [
    ]
  },
  ready: function() {
        this.fetchClients();
    },
    methods: {
        fetchClients: function() {
            this.$http.get('/admin/screengroups', function(clients) {
            this.$set('gridData', clients);
            });
        }
    }
});
</script>