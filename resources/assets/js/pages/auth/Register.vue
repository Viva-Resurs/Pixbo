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
    </div></template>

<script>
    module.exports = {

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
            registerUser: function (e) {
                e.preventDefault()
                var that = this
                that.registering = true
                client({ path: '/auth/signup', entity: this.user }).then(
                        function (response) {
                            that.getUserData()
                        },
                        function (response, status) {
                            that.messages = []
                            if (response.status && response.status.code === 422) {
                                that.messages = []
                                for (var key in response.entity.error.errors) {
                                    that.$dispatch('alert', {message: response.entity.error.errors[key][0]})
                                    that.registering = false
                                }
                            }
                        }
                )

            },

            getUserData: function () {
                var that = this
                client({ path: '/users/me' }).then(
                        function (response) {
                            that.$dispatch('userHasLoggedIn', response.entity.user)
                            that.$route.router.go('/auth/profile')
                        }
                )
            }
        }
    }
</script>

