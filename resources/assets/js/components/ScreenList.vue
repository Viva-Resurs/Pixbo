<template>

    <div class="panel-section" v-if="screens.length == 0">
        {{ trans('screen.empty') }}
    </div>

    <div class="panel-section" v-if="screens.length > 0">

        <search-filter v-if="from=='screen'"
            :search.sync="search"
        >
            <div slot="searchfilter_right">
                <div class="pull-right">
                    <div class="input-group">
                        <select class="form-control selectpicker show-tick"
                                v-model="order"
                                
                                id="order"
                                v-el:select-inputb
                        >
                            <option v-for="(key, value) in columns" :value="key">{{value.title}}</option>
                        </select>
                        <span class="input-group-addon">
                            <span class="fa fa-sort"></span>
                        </span>
                    </div>
                </div>
            </div>
        </search-filter>

        <div class="row">
            <div v-for="screen in screens | orderBy deepSort | filterBy searchFilter | filterBy rangeFilter">
                <screen-card :screen="screen" :from="from"></screen-card>
            </div>
        </div>

        <pagination
            :total.sync="screens.length"
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
    import ScreenCard from './ScreenCard.vue'
    import SortingData from '../mixins/SortingData.vue'
    import Pagination from './Pagination.vue'
    import SearchFilter from './SearchFilter.vue'

    export default {

        name: 'ScreenList',

        props: [ 'screens', 'from' ],

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

        mixins: [ SortingData ],

        components: [ ScreenCard, Pagination, SearchFilter ],

        methods: {

            // Use searchFilter
            searchFilter(object,index){
                return SearchFilter.filters.searchFilter(object,index,this.search,this.columns);
            },

            // Use rangeFilter
            rangeFilter(object,index){
                return Pagination.filters.rangeFilter(object,index,this);
            },

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
                'photo.originalName' : { title: this.trans('general.name'),       type: 'string', search: true  },
                'event.updated_at'   : { title: this.trans('general.updated_at'), type: 'number', search: false }
            };

            this.$nextTick(function() {

                var target = $(this.$els.selectInputb);

                let g = target.selectpicker({
                    size: 4,
                    iconBase: 'fa',
                    tickIcon: 'fa-check'
                });

                target.selectpicker('refresh');

            });
        }

    }
</script>
