<template lang="html">

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
                    <th>{{ trans('general.text') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='text') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='text' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('text')"></button>
                    </th>
                    <th class="slim" v-if="from!='screengroup'">{{ this.trans('screengroup.model') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='screengroups') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='screengroups' && desc==-1) ? ' fa-sort-amount-desc' : ' fa-sort-amount-asc'}}
                        " @click="setOrder('screengroups')"></button>
                    </th>
                    <th class="slim">{{ trans('general.updated_at') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='event.updated_at') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='event.updated_at' && desc==-1) ? ' fa-caret-up' : ' fa-caret-down'}}
                        " @click="setOrder('event.updated_at',1)"></button>
                    </th>
                    <th class="slim">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="ticker in tickers | filterBy isNotRemoved | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter">
                    <td><a v-link="{ path: '/tickers/'+ticker.id }">{{ ticker.text }}</a></td>
                    <td class="slim">
                        <span v-for="sg in ticker.screengroups">
                            <template v-if="$route.path == '/screengroups/'+sg.id">
                                <b>{{ sg.name }}</b>
                            </template>
                            <template v-else>
                                <a v-if="ticker.screengroups.length>3" v-link="{ path: '/screengroups/'+sg.id }"
                                   v-tooltip data-original-title='{{sg.name}}'>{{ sg.name.substring(0,7)+'..' }}</a>
                                <a v-else v-link="{ path: '/screengroups/'+sg.id }">{{ sg.name }}</a>
                            </template>

                        </span>
                    </td>
                    <td class="slim">{{ ticker.event.updated_at.substring(0,ticker.event.updated_at.indexOf(' ')) }}</td>
                    <td class="slim">
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/tickers/'+ticker.id }"
                            v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a v-if="this.from=='screengroup'" class="btn btn-primary hover-danger btn-xs fa fa-minus"
                            v-on:click="$dispatch('remove-ticker', ticker)"
                            v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></a>
                        <a v-else class="btn btn-primary hover-danger btn-xs fa fa-times"
                            v-on:click="$dispatch('remove-ticker', ticker)"
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
    import Validators from '../mixins/Validators.vue'
    import Pagination from './Pagination.vue'
    import SearchFilter from './SearchFilter.vue'

    export default {

        name: 'TickerList',

        props: [ 'tickers', 'from' ],

        mixins: [ SortingData, Validators ],

        components: [ Pagination, SearchFilter ],

        data: function(){
            return {
                search: '',
                targets: ['text','screengroups'],

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
