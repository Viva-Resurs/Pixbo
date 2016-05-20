<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if=" categories.length == 0 ">
            {{ trans('category.empty') }}
        </div>

        <table class="table" v-if=" categories.length > 0 ">
            <thead>
                <tr>
                    <th>{{ trans('general.id') }}</th>
                    <th>{{ trans('general.name') }}</th>
                    <th>{{ trans_choice('screen.model', 2) }}</th>
                    <th width="120px">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>{{ category.id }}</td>
                    <td><a v-link="{ path: '/categories/'+category.id }">{{ category.name }}</a></td>
                    <td>{{ category.numberOfScreens }}</td>
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/categories/'+category.id }"
                          v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-if="category.id !== 1" v-on:click="attemptDeleteCategory($index)"
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
                categories: {
                    id: null,
                    name: null,
                    screens: null
                }
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/categories' }).then(
                    function (response) {
                        that.$set('categories', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            that.$dispatch('userHasLoggedOut')
                        }
                    }
                )
            },

            attemptDeleteCategory(index) {
                // TODO: Add some kind of confirmation
                this.deleteCategory(index)
            },

            deleteCategory: function (index) {
                var that = this
                client({ path: '/categories/' + this.categories[index].id, method: 'DELETE' }).then(
                    function (response) {
                        that.categories.splice(index, 1)
                        that.$dispatch('alert', {
                            message: that.trans('category.deleted'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('category.deleted_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({categories: data})
                })
            }
        }

    }
</script>
