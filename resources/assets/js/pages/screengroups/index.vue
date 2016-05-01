<template>
    <div class="panel-heading">
        {{ trans('screengroup.archive') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if="screengroups.length == 0">
        {{ trans('screengroup.empty') }}
    </div>

    <table class="table" v-if=" ! $loadingRouteData && screengroups.length > 0">
        <thead>
            <tr>
                <th>{{ trans('general.id') }}</th>
                <th>{{ trans('general.name') }}</th>
                <th>{{ trans('general.desc') }}</th>
                <th width="120px">{{ trans('general.action') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="screengroup in screengroups">
                <td>{{ screengroup.id }}</td>
                <td>{{ screengroup.name }}</td>
                <td>{{ screengroup.desc }}</td>
                <td>
                    <a class="btn btn-primary btn-xs" v-link="{ path: '/screengroups/'+screengroup.id }">{{ trans('general.edit') }}</a>
                    <a class="btn btn-primary btn-xs" v-on:click="deleteScreengroup($index)">{{ trans('general.delete') }}</a>
                </td>
            </tr>
        </tbody>
    </table></template>

<script>
    module.exports = {

        data: function () {
            return {
                screengroups: [],
                messages: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/screengroups' }).then(
                        function (response) {
                            that.$set('screengroups', response.entity.data)
                            successHandler(response.entity.data)
                        },
                        function (response, status) {
                            if (_.contains([401, 500], status)) {
                                that.$dispatch('userHasLoggedOut')
                            }
                        }
                )
            },

            deleteScreengroup: function (index) {
                var that = this
                client({ path: '/screengroups/' + this.screengroups[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.screengroups.splice(index, 1)
                            that.messages = [{type: 'success', message: trans('screengroup.deleted')}]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: trans('screengroup.deleted_fail') })
                        }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screengroups: data})
                })
            }
        }

    }
</script>
