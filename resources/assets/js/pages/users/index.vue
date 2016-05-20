<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if=" users.length == 0 ">
            {{ trans('user.empty') }}
        </div>

        <table class="table" v-if=" users.length > 0 ">
            <thead>
                <tr>
                    <th>{{ trans('general.id') }}</th>
                    <th>{{ trans('general.name') }}</th>
                    <th>{{ trans('general.email') }}</th>
                    <th>{{ trans('role.model') }}</th>
                    <th width="120px">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users">
                    <!-- TODO: Hide yourself -->
                    <td>{{ user.id }}</td>
                    <td><a v-link="{ path: '/users/'+user.id }">{{ user.name }}</a></td>
                    <td>{{ user.email }}</td>
                    <td><span v-for="role in user.roles.data">{{ role.name }}</span></td>
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/users/'+user.id }"
                          v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-on:click="attemptDeleteUser($index)"
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
                users: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/users' }).then(
                    function (response) {
                        that.$set('users', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            that.$dispatch('userHasLoggedOut')
                        }
                    }
                )
            },

            attemptDeleteUser(index) {
                // TODO: Add some kind of confirmation
                this.deleteUser(index)
            },

            deleteUser: function (index) {
                var that = this
                client({ path: '/users/' + this.users[index].id, method: 'DELETE' }).then(
                    function (response) {
                        that.users.splice(index, 1)
                        that.$dispatch('alert', {
                            message: that.trans('user.deleted'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('user.deleted_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({users: data})
                })
            }
        }

    }
</script>
