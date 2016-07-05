<template>

    <div class="panel-heading">
        {{ trans('auth.login') }}
    </div>

    <div class="panel-body">

        <form class="form-horizontal" role="form" v-on:submit="attempt">

            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('auth.name') }}</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" v-model="user.name">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('auth.password') }}</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" v-model="user.password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary" :disabled="loggingIn">
                        <i class="fa fa-btn fa-sign-in"></i>{{ trans('auth.login') }}
                    </button>
                    <a class="btn btn-link" v-link="{ path: '/auth/forgot' }">{{ trans('auth.forgot_password') }}</a>
                </div>
            </div>

        </form>

    </div>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'Login',

        data: function () {
            return {
                user: {
                    name: null,
                    password: null
                },
                messages: [],
                loggingIn: false
            }
        },

        methods: {

            attempt: function (e) {

                e.preventDefault();

                this.loggingIn = true;

                var self = this;

                client({ path: 'auth/login', entity: self.user }).then(

                    function (response) {

                        self.$dispatch('userHasFetchedToken', response.token);
                        self.getUserData();

                    },

                    function (response) {

                        self.messages = [];

                        if (response.status && response.status.code === 401)
                            self.$dispatch('alert', {message: self.trans('auth.invalid_credentials')});

                        self.loggingIn = false;

                    }

                );
            },

            getUserData: function () {

                var self = this;

                client({ path: '/users/me' }).then(

                    function (response) {

                        self.$dispatch('userHasLoggedIn', response.entity.data);
                        self.$route.router.go({ name: 'screengroups.index'});

                    },

                    function (response) {
                        console.log(response);
                    }

                );

            }

        },

        route: {
            activate: function (transition) {
                this.$dispatch('userHasLoggedOut')
                transition.next()
            }
        }

    }
</script>
