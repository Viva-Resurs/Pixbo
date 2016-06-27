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
            <!-- TODO: Minify name and link? -->
            <td><span v-for="sg in getScreengroup(ticker)">{{ sg.name }}</span></td>
            <td>
                <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/tickers/'+ticker.id }"
                   v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                <template v-if="this.from=='screengroup'">
                    <a class="btn btn-primary btn-xs fa fa-minus" v-on:click="removeTicker($index)"
                       v-tooltip data-original-title="{{ trans('screengroup.remove_association')  }}"></a>
                </template>
                <template v-else>
                    <a class="btn btn-primary btn-xs fa fa-times" v-on:click="removeTicker($index)"
                       v-tooltip data-original-title="{{ trans('general.delete')  }}"></a>
                </template>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script type="text/ecmascript-6">
    export default {
        props: ['tickers','from'],

        methods: {
            removeTicker(index) {
                this.$dispatch('remove-ticker', index)
            },
            getScreengroup(ticker) {
                return ticker.screengroups;
            }
        }
    }
</script>