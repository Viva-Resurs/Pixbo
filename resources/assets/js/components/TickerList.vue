<template>

    <div class="panel-section" v-if="tickers.length == 0">
        {{ trans('ticker.empty') }}
    </div>

    <div class="panel-section" v-if="tickers.length > 0">

        <search-filter v-if="from!='screengroup'"
            :search.sync="search"
        >
        </search-filter>

        <table class="table">
            <thead>
                <tr>
                    <th v-for="(key, value) in columns" class="{{ value.classes }}">
                        {{ value.title }}
                        <button class="
                            btn btn-xs fa fa-btn
                            {{ (this.order==key) ? 'btn-primary ' : 'btn-default '}}
                            {{ (value.type=='number') ? (this.order==key && this.desc==-1) ? ' fa-caret-up' : ' fa-caret-down' : '' }}
                            {{ (value.type=='string') ? (this.order==key && this.desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc' : '' }}
                            {{ (value.type=='object') ? (this.order==key && this.desc==-1) ? ' fa-sort-amount-desc' : ' fa-sort-amount-asc' : '' }}
                        " @click="setOrder(key)"></button>
                    </th>
                    <th>{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="object in tickers | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter" v-if="typeof object == 'object'">
                    <td class="hidden">{{ object.id }}</td>
                    <td><a v-link="{ path: '/tickers/'+object.id }">{{ object.text }}</a></td>
                    <td class="slim">
                        <span v-for="sg in object.screengroups">
                            <template v-if="$route.path == '/screengroups/'+sg.id">
                                <b>{{ sg.name }}</b>
                            </template>
                            <template v-else>
                                <a v-if="object.screengroups.length>3" v-link="{ path: '/screengroups/'+sg.id }"
                                   v-tooltip data-original-title='{{sg.name}}'>{{ sg.name.substring(0,7)+'..' }}</a>
                                <a v-else v-link="{ path: '/screengroups/'+sg.id }">{{ sg.name }}</a>
                            </template>
                            
                        </span>
                    </td>
                    <td class="slim">{{ object.event.updated_at.substring(0,object.event.updated_at.indexOf(' ')) }}</td>
                    <td class="slim">
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/tickers/'+object.id }"
                           v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a v-if="this.from=='screengroup'" class="btn btn-primary btn-xs fa fa-minus" v-on:click="removeObject(object.id)"
                           v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></a>
                        <a v-else class="btn btn-primary hover-danger btn-xs fa fa-times" v-on:click="removeObject(object.id)"
                           v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            :total.sync="tickers.length"
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
import Pagination from './Pagination.vue'
import SearchFilter from './SearchFilter.vue'

    export default {

        name: 'TickerList',

        props: [ 'tickers', 'from' ],

        mixins: [ SortingData ],

        components: [ Pagination, SearchFilter ],

        data: function(){
            return {
                columns: {},

                search: '',

                limitOff: false,
                limitOffBtn: false,
                
                order: 'event.updated_at',
                desc: -1,

                offset: 0,
                limit: 10,
            }
        },

        methods: {

            // Use searchFilter
            searchFilter(object,index){
                return SearchFilter.filters.searchFilter(object,index,this.search,this.columns);
            },

            // Use rangeFilter
            rangeFilter(object,index){
                return Pagination.filters.rangeFilter(object,index,this);
            },

            // Removing objects
            removeObject(id) {
                this.$dispatch('remove-ticker', id);
            }

        },

        watch: {
            // Reset show all results when editing search
            search: function(val, oldVal){
                this.offset = 0;
                this.limitOff = false;
            }
        },

        created: function(){
            this.columns = {
                'text'             : { title: this.trans('general.text'),       type: 'string', classes:     '', search: true  },
                'screengroups'     : { title: this.trans('screengroup.model'),  type: 'object', classes: 'slim', search: true  },
                'event.updated_at' : { title: this.trans('general.updated_at'), type: 'number', classes: 'slim', search: false }
            };
        }

    }
</script>
