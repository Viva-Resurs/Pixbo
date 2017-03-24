 <template>

    <div class="panel-section" v-if="screengroups.length == 0">
        {{ trans('screengroup.empty') }}
    </div>

    <div class="panel-section" v-if="screengroups.length > 0">

        <search-filter
            :search.sync="search"
        >
        </search-filter>

        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('general.name') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='name') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='name' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('name')"></button>
                    </th>
                    <th>{{ trans('general.desc') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='desc') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='desc' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('desc')"></button>
                    </th>
                    <th class="slim">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="screengroup in screengroups | filterBy isNotRemoved | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter">
                    <td><a v-link="{ path: '/screengroups/'+screengroup.id }">{{ screengroup.name }}</a></td>
                    <td>{{ screengroup.desc }}</td>
                    <td class="slim">
                        <a class="btn btn-primary btn-xs fa fa-eye " href="play?mac={{screengroup.preview}}&preview=yes" target="_blank"
                            v-tooltip data-original-title="{{ trans('general.preview') }}" :disabled="screengroup.preview === ''"></a>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-if="$root.isAdmin" v-link="{ path: '/screengroups/'+screengroup.id }"
                            v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary hover-danger btn-xs fa fa-times"
                            v-if="$root.isAdmin" v-on:click="$dispatch('remove-screengroup', screengroup)"
                            v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            :total.sync="screengroups.length"
            :offset.sync="offset"
            :limit.sync="limit"
            :show-pagination="(search=='' && !limitOffBtn)"
        >
            <div slot="replacePagination">
                <button v-if="limitOffBtn" class="btn btn-default searchresults_expander" @click="limitOff = true">
                    {{ trans('general.showallresults') }}
                </button>
            </div>
        </pagination>

    </div>

</template>

<script type="text/ecmascript-6">
    import SortingData from '../mixins/SortingData.vue'
    import Validators from '../mixins/Validators.vue'
    import Pagination from './Pagination.vue'
    import SearchFilter from './SearchFilter.vue'

    export default {

        name: 'ScreengroupList',

        props: [ 'screengroups' ],

        mixins: [ SortingData, Validators ],

        components: [ Pagination, SearchFilter ],

        data: function(){
            return {
                search: '',
                targets: ['name','desc'],

                limitOff: false,
                limitOffBtn: false,

                order: 'name',
                desc: 1,

                offset: 0,
                limit: 10,
            }
        },

        methods: {

            // Use searchFilter
            searchFilter(object,index){
                return SearchFilter.filters.searchFilter(object,index,this.search,this.targets);
            },

            // Use rangeFilter
            rangeFilter(object,index){
                return Pagination.filters.rangeFilter(object,index,this);
            }

        },

        watch: {
            // Reset show all results when editing search
            search: function(val, oldVal){
                this.offset = 0;
                this.limitOff = false;
            }
        }

    }
</script>
