<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>
        <user-list :users="users"></user-list>
    </div>   

</template>

<script type="text/ecmascript-6">
    import UserList from '../../components/UserList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { UserList },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                users: []
            }
        },

        methods: {

            attemptDeleteUser(user) {

                this.confirm({
                    callback:this.deleteUser, arg:user,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteUser(user) {

                var self = this;

                client({ path: '/users/' + user.id, method: 'DELETE' }).then(

                    function (response) {

                        user.removed = true;
                        self.users.reverse();

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

        ready: function() {
            this.$on('remove-user', function (user) {
                this.attemptDeleteUser(user);
            });
        },

        route: {
            data: function (transition) {
                client({ path: '/users' }).then(
                    function (response) {
                        transition.next({users: response.entity.data});
                    },
                    function (response){
                        transition.next();
                        console.error(response.entity.error);
                    }
                );
            }
        }

    }
</script>
