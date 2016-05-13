<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if=" messages.length > 0 ">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>

        <div class="panel-body" v-if=" users.length == 0 ">
            {{ trans('user.empty') }}
        </div>

        <table class="table" v-if=" users.length > 0 ">
            <thead>
                <tr>
                    <th>{{ trans('general.id') }}</th>
                    <th>{{ trans('general.name') }}</th>
                    <th>{{ trans('general.age') }}</th>
                    <th width="120px">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.age }}</td>
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/users/'+user.id }"
                          v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-on:click="deleteUser($index)"
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
                users: [],
                messages: []
            }
        },

        methods: {
            // Let's fetch some dogs
            fetch: function (successHandler) {
                var that = this
                client({ path: '/users' }).then(
                        function (response) {
                            // Look ma! Puppies!
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

            deleteUser: function (index) {
                var that = this
                client({ path: '/users/' + this.users[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.users.splice(index, 1)
                            that.messages = [{type: 'success', message: 'Great, users purged.'}]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: 'There was a problem removing the user'})
                        }
                )
            }

        },

        route: {
            // Ooh, ooh, are there any new puppies yet?
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({users: data})
                })
            }
        }

    }
</script>
