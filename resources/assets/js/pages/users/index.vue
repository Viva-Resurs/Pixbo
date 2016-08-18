<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if="users.length == 0">
            {{ trans('user.empty') }}
        </div>

        <table class="table" v-if="users.length > 0">
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

<script type="text/ecmascript-6">
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        mixins: [ SweetAlert ],

        data: function () {
            return {
                users: []
            }
        },

        methods: {

            fetch() {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/users' }).then(

                    function (response) {

                        self.$set('users', response.entity.data);

                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                        if (!self.attempts || self.attempts < 3)

                            setTimeout(function(){

                                self.attempts = (self.attempts) ? self.attempts+1 : 1;
                                self.fetch();

                            },1000);

                    }

                );

            },

            attemptDeleteUser(index) {

                this.confirm({
                    callback:this.deleteUser, arg:index,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteUser(index) {

                var self = this;

                client({ path: '/users/' + self.users[index].id, method: 'DELETE' }).then(

                    function (response) {

                        self.users.splice(index, 1);

                        self.$dispatch('alert', {
                            message: self.trans('user.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('user.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        created: function(){
            this.fetch();
        }

    }
</script>
