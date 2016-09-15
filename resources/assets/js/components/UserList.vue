<template>

    <div class="panel-section" v-if="users.length == 0">
        {{ trans('user.empty') }}
    </div>

    <div class="panel-section" v-if="users.length > 0">

        <search-filter
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
                <tr v-for="object in users | filterBy validator | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter">
                    <td class="hidden">{{ object.id }}</td>
                    <td><a v-link="{ path: '/users/'+object.id }">{{ object.name }}</a></td>
                    <td>{{ object.email }}</td>
                    <td class="slim"><span v-for="role in object.roles.data">{{ role.name }}</span></td>
                    <td class="slim">
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/users/'+object.id }"
                           v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a v-else class="btn btn-primary hover-danger btn-xs fa fa-times" v-on:click="removeObject(object.id)"
                           v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            :total.sync="users.length"
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

        name: 'UserList',

        props: [ 'users' ],

        mixins: [ SortingData ],

        components: [ Pagination, SearchFilter ],

        data: function(){
            return {
                columns: {},

                search: '',

                limitOff: false,
                limitOffBtn: false,
                
                order: 'name',
                desc: 1,

                offset: 0,
                limit: 10,
            }
        },

        methods: {

            // Validator filter
            validator(object,index){
                if (typeof object != 'object')
                    return false;
                return true;
            },
            
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
                this.$dispatch('remove-user', id);
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
                'name'       : { title: this.trans('general.name'),  type: 'string', classes:     '', search: true },
                'email'      : { title: this.trans('general.email'), type: 'string', classes:     '', search: true },
                'roles.data' : { title: this.trans('role.model'),    type: 'string', classes: 'slim', search: true }
            };
        }

    }
</script>
