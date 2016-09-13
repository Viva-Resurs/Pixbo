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

            attemptDeleteUser(userID) {

                this.confirm({
                    callback:this.deleteUser, arg:userID,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteUser(userID) {

                var self = this;

                var removeIndex = -1;

                for (var i=0; i<self.users.length ; i++)
                    if (self.users[i].id == userID)
                        removeIndex = i;

                if (removeIndex==-1)
                    return self.$dispatch('alert', {
                        message: self.trans('user.deleted_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/users/' + userID, method: 'DELETE' }).then(

                    function (response) {

                        self.users.splice(removeIndex, 1);

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
            this.$on('remove-user', function (userID) {
                this.attemptDeleteTicker(userID);
            });
        },

        created: function(){
            this.fetch();
        }

    }
</script>
