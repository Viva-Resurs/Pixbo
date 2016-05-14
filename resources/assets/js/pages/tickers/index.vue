<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if=" tickers.length == 0 ">
            {{ trans('ticker.empty') }}
        </div>

        <table class="table" v-if=" tickers.length > 0 ">
            <thead>
                <tr>
                    <th>{{ trans('general.id') }}</th>
                    <th>{{ trans('general.text') }}</th>
                    <th width="120px">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="ticker in tickers">
                    <td>{{ ticker.id }}</td>
                    <td>{{ ticker.text }}</td>
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/tickers/'+ticker.id }"
                          v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-on:click="deleteTicker($index)"
                          v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script>
    module.exports = {

        data: function () {
            return {
                tickers: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/tickers' }).then(
                    function (response) {
                        that.$set('tickers', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            that.$dispatch('userHasLoggedOut')
                        }
                    }
                )
            },

            deleteTicker: function (index) {
                var that = this
                client({ path: '/tickers/' + this.tickers[index].id, method: 'DELETE' }).then(
                    function (response) {
                        that.tickers.splice(index, 1)
                        that.$dispatch('alert', {
                            message: that.trans('ticker.deleted'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('ticker.delete_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({tickers: data})
                })
            }
        },

    }
</script>
