<template>

    <div class="panel-body" v-if="tickers.length == 0">
        {{ trans('ticker.empty') }}
    </div>

    <div class="panel-body" v-if="tickers.length > 0">

        <div class="search_group">
            <label for="search" class="search_label">{{ trans('general.search') }}</label>
            <div class="search_input">
                <input class="form-control"
                       name="search"
                       id="search"
                       type="text"
                       v-model="search"
                       v-on:keyup="resetMaxResults"
                >
                <span class="fa fa-search search_icon"></span>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('general.id') }}</th>
                    <th>{{ trans('general.text') }}</th>
                    <th>{{ trans('screengroup.model') }}</th>
                    <th width="120px">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="ticker in tickers | orderBy order desc | filterBy filter | filterBy pagination">
                    <td>{{ ticker.id }}</td>
                    <td><a v-link="{ path: '/tickers/'+ticker.id }">{{ ticker.text }}</a></td>
                    <td>
                        <span v-for="sg in getScreengroup(ticker)">
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
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/tickers/'+ticker.id }"
                           v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a v-if="this.from=='screengroup'" class="btn btn-primary btn-xs fa fa-minus" v-on:click="removeTicker($index)"
                           v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></a>
                        <a v-else class="btn btn-primary btn-xs fa fa-times" v-on:click="removeTicker($index)"
                           v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="btn-toolbar pagination" v-show="search==''">
            <div class="btn-group" role="group">
                <button class="btn btn-default" @click="firstPage"><span class="fa fa-btn fa-angle-double-left"></span></button>
            </div>
            <div v-for="n in countPages()" class="btn-group" role="group">
                <button class="btn btn-{{(n+1==getCurrentPage()) ? 'primary' : 'default'}}" @click="toPage(n)">{{n+1}}</button>
            </div>
            <div class="btn-group" role="group">
                <button class="btn btn-default" @click="lastPage"><span class="fa fa-btn fa-angle-double-right"></span></button>
            </div>
        </div>

        <div class="search" v-show="search!='' && maxResults!=0">
            <button class="btn btn-default" @click="showAllResults">{{ trans('general.showallresults') }}</button>
        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import FilterTools from '../components/FilterTools.vue'

    export default {

        name: 'TickerList',

        props: [ 'tickers', 'from' ],

        data: function(){
            return {
                order: 'event.updated_at',
                desc: -1,
                search: '',
                offset: 0,
                maxIthems: 7,
                maxResults: 7,
            }
        },

        methods: {

            firstPage(){
                this.offset = 0
            },

            lastPage(){
                this.offset = this.tickers.length-(((this.tickers.length-1)%this.maxIthems)+1);
            },

            toPage(p){
                this.offset = p*this.maxIthems;
            },

            countPages(){
                var p = 1;
                for (var i=0, c=0 ; i<this.tickers.length ; i++, c++){
                    if (c+1==this.maxIthems && i<this.tickers.length-p){
                        p++; c=0;
                    }
                }
                return p;
            },

            getCurrentPage(){
                var p = 1;
                for (var i=0, c=0 ; i<this.tickers.length ; i++, c++){
                    if (i==this.offset)
                        return p;
                    if (c+1==this.maxIthems){
                        p++; c=0;
                    }
                }
            },

            filter(ob){
                for (var property in ob)
                    if (String(ob[property]).indexOf(this.search)>-1)
                        return true;
                return false;
            },

            showAllResults(){
                this.maxResults = 0;
            },

            resetMaxResults(){
                this.maxResults = 6;
            },

            pagination(ob,index){
                // When searching, only show matches
                if (this.search!=''){
                    if (this.maxResults)
                        return (index<this.maxResults);
                    else
                        return true;
                }

                // Show contents in range
                return (index >= this.offset && index < this.offset+this.maxIthems)
            },

            removeTicker(index) {
                this.$dispatch('remove-ticker', index);
            },

            getScreengroup(ticker) {
                return ticker.screengroups;
            }

        }

    }
</script>
