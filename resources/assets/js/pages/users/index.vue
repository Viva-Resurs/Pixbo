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

                    }

                );

            },

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

        created: function(){
            this.fetch();
        }

    }
</script>
