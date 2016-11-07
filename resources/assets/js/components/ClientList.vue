<template>

    <div class="panel-section" v-if="clients.length == 0">
        {{ trans('client.empty') }}
    </div>

    <div class="panel-section" v-if="clients.length > 0">

        <search-filter v-if="from!='screengroup'"
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
                    <th class="slim" v-if="from!='screengroup'">{{ this.trans('screengroup.model',1) }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='screengroup.data.name') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='screengroup.data.name' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('screengroup.data.name')"></button>
                    </th>
                    <th class="slim">{{ trans('general.mac_address') }}
                        <button class=" btn btn-xs fa fa-btn
                            {{ (order=='address') ? 'btn-primary ' : 'btn-default '}}
                            {{ (order=='address' && desc==-1) ? ' fa-sort-alpha-desc' : ' fa-sort-alpha-asc'}}
                        " @click="setOrder('address')"></button>
                    </th>
                    <th class="slim">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients | filterBy isNotRemoved | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter">
                    <td>
                        <a v-if="$root.isAdmin" v-link="{ path: '/clients/'+client.id }">{{ client.name }}</a>
                        <span v-else>{{ client.name }}</span>
                    </td>
                    <td v-if="from!='screengroup'">
                        <template v-if="client.screengroup">
                            <a v-link="{ path: '/screengroups/'+client.screengroup.data.id }">{{ client.screengroup.data.name }}</a>
                        </template>
                    </td>
                    <td class="slim" v-if="$root.isAdmin">{{ client.address }}</td>
                    <td class="slim">
                        <a class="btn btn-primary btn-xs fa fa-eye" href="/play?mac={{client.address}}&preview=yes" target="_blank"
                            v-tooltip data-original-title="{{ trans('general.preview') }}"></a>
                        <template v-if="$root.isAdmin">
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/clients/'+client.id }"
                            v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a v-if="this.from=='screengroup'" class="btn btn-primary hover-danger btn-xs fa fa-minus"
                            v-on:click="$dispatch('remove-client', client)"
                            v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></a>
                        <a v-else class="btn btn-primary hover-danger btn-xs fa fa-times"
                            v-on:click="$dispatch('remove-client', client)"
                            v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            :total.sync="clients.length"
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

        name: 'ClientList',

        props: [ 'clients', 'from' ],

        mixins: [ SortingData, Validators ],

        components: [ Pagination, SearchFilter ],

        data: function(){
            return {
                search: '',
                targets: ['name','screengroup.data.name','address'],

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
