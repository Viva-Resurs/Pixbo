<template>

    <div class="panel-section" v-if="activitylog.length == 0">
        {{ trans('general.empty') }}
    </div>

    <div class="panel-section" v-if="activitylog.length > 0 && $root.isAdmin">

        <search-filter v-if="from!='screengroup'"
            :search.sync="search"
        >
        </search-filter>

        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('user.model',1) }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='user.name') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='user.name' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('user.name')"></button>
                    </th>
                    <th>{{ trans('general.desc') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='desc') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='desc' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('desc')"></button>
                    </th>
                    <th class="slim">{{ trans('general.timestamp') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='datetime') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='datetime' && desc==-1) ? ' fa-caret-up' : ' fa-caret-down'}}
                        " @click="setOrder('datetime',1)"></button>
                    </th>
                    <th class="slim">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="activity in activitylog | filterBy isNotRemoved | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter">
                    <td><a v-link="{ path: '/users/'+activity.user.id }">{{ activity.user.name }}</a></td>
                    <!--td><a v-link="{ path: '/activity/'+activity.id }">{{ activity.desc }}</a></td-->
                    <td>{{ activity.desc }}</td>
                    <td>{{ activity.datetime.substring(0,activity.datetime.indexOf(' ')) }}</td>
                    <td class="slim">
                        <a class="btn btn-primary hover-danger btn-xs fa fa-times"
                            v-on:click="$dispatch('remove-activity', activity)"
                            v-tooltip data-original-title="{{ trans('general.delete') }}"></a>

                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            :total.sync="activitylog.length"
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

        name: 'ActivityLog',

        props: [ 'activitylog' ],

        mixins: [ SortingData, Validators ],

        components: [ Pagination, SearchFilter ],

        data: function(){
            return {
                search: '',
                targets: ['user.name','desc','datetime'],

                limitOff: false,
                limitOffBtn: false,
                
                order: 'datetime',
                desc: -1,

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
