<template>

    <div class="panel-heading">
        {{ trans('auth.register') }}
    </div>

    <div class="panel-body">

        <form class="form-horizontal" role="form" v-on:submit="registerUser">

            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('general.name') }}</label>
                <div class="col-md-6">
                    <input type="name" class="form-control" v-model="user.name">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('general.email') }}</label>
                <div class="col-md-6">
                    <input type="email" class="form-control" v-model="user.email">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('auth.password') }}</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" v-model="user.password">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('auth.password_repeat') }}</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" v-model="user.password_confirmation">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary" :disabled="registering">
                        <i class="fa fa-btn fa-sign-in"></i> {{ trans('auth.register') }}
                    </button>
                </div>
            </div>

        </form>

    </div>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'Register',

        // TODO: Add client validation

        data: function () {
            return {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                },
                messages: [],
                registering: false
            }
        },

        methods: {

            registerUser(e) {

                e.preventDefault();

                var self = this;

                self.registering = true;

                client({ path: '/auth/signup', entity: this.user }).then(

                    function (response) {

                        self.getUserData();

                    },

                    function (response, status) {

                        if (response.status && response.status.code === 422) {

                            self.messages = [];

                            for (var key in response.entity.error.errors) {

                                self.$dispatch('alert', {message: response.entity.error.errors[key][0]});
                                self.registering = false;

                            }

                        }

                    }

                );

            },

            getUserData() {

                var self = this;

                client({ path: '/users/me' }).then(
                        function (response) {
                            self.$dispatch('userHasLoggedIn', response.entity.user)
                            self.$route.router.go('/auth/profile')
                        }
                );

            }

        }

    }
</script>
