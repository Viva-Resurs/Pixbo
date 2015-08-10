<!-- component template -->
<script type="text/x-template" id="grid-template">
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
</script>
