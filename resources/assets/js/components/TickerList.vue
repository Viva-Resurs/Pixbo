/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <div class="panel-body" v-if=" tickers.length == 0 ">
        {{ trans('ticker.empty') }}
    </div>

    <table class="table" v-if=" tickers.length > 0 ">
        <thead>
        <tr>
            <th>{{ trans('general.id') }}</th>
            <th>{{ trans('general.text') }}</th>
            <th>{{ trans('screengroup.model') }}</th>
            <th width="120px">{{ trans('general.action') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="ticker in tickers">
            <td>{{ ticker.id }}</td>
            <td><a v-link="{ path: '/tickers/'+ticker.id }">{{ ticker.text }}</a></td>
            <td>
                <span v-for="sg in getScreengroup(ticker)">
                    <template v-if="$route.path == '/screengroups/'+sg.id">
                        <b>{{ sg.name }}</b>
                    </template>
                    <template v-else>
                        <a v-if="ticker.screengroups.length>3" v-link="{ path: '/screengroups/'+sg.id }"
                           v-tooltip data-original-title='{{sg.name}}'>{{ minify(sg.name) }}</a>
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
</template>

<script type="text/ecmascript-6">
    export default {
        props: ['tickers','from'],

        computed: {

        },
        methods: {
            minify(name){
                return name.substring(0,7)+'..';
            },
            removeTicker(index) {
                this.$dispatch('remove-ticker', index)
            },
            getScreengroup(ticker) {
                return ticker.screengroups;
            }
        }
    }
</script>