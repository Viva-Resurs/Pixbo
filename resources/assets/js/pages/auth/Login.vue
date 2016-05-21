<template>
    <div class="panel-heading">
        {{ trans('auth.login') }}
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" v-on:submit="attempt">

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

<script>
    module.exports = {

        data: function () {
            return {
                user: {
                    email: null,
                    password: null
                },
                messages: [],
                loggingIn: false
            }
        },

        methods: {
            attempt: function (e) {
                e.preventDefault()
                var that = this
                that.loggingIn = true
                client({ path: 'auth/login', entity: this.user }).then(
                        function (response) {
                            that.$dispatch('userHasFetchedToken', response.token)
                            that.getUserData()
                        },
                        function (response) {
                            that.messages = []
                            if (response.status && response.status.code === 401) {
                                that.$dispatch('alert', {message: that.trans('auth.invalid_credentials')})
                            }
                            that.loggingIn = false
                        }
                )
            },

            getUserData: function () {
                var that = this
                client({ path: '/users/me' }).then(
                        function (response) {
                            that.$dispatch('userHasLoggedIn', response.entity.data)
                            that.$route.router.go('/auth/profile')
                        },
                        function (response) {
                            console.log(response)
                        }
                )
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

