<template>
    
    <div class="panel-heading">
        {{ trans('auth.password_reset') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div v-if="user.token && user.email">

            <form v-if="!done" class="form-horizontal" role="form" v-on:submit.prevent="attemptResetPassword" name="myform" v-form>
            
                <div class="panel-body">

                    <div class="form-group" v-validation-help>
                        <label for="password" class="model_label">{{ trans('auth.password_new') }}</label>
                        <div class="model_input">
                            <input class="form-control"
                                   name="password" id="password"
                                   type="password"
                                   v-model="user.password"
                                   v-form-ctrl
                                   required
                                   minlength="8"
                                   maxlength="30"
                            >
                        </div>
                    </div>

                    <div class="form-group" v-validation-help>
                        <label for="password" class="model_label">{{ trans('auth.password_new_repeat') }}</label>
                        <div class="model_input">
                            <input class="form-control"
                                   name="password_confirmation" id="password_confirmation"
                                   type="password"
                                   v-model="user.password_confirmation"
                                   v-form-ctrl
                                   v-is-equal="user.password"
                                   required
                                   minlength="8"
                                   maxlength="30"
                            >
                        </div>
                    </div>

                </div>

                <div class="panel-footer text-right">

                    <button type="button" class="btn btn-default" @click="goBack" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="button" class="btn btn-default" @click="goBack" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptResetPassword">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                    
                </div>

            </form>

        </div>

        <div v-else>

            <form v-if="!done" class="form-horizontal" role="form" v-on:submit.prevent="attemptSendResetLink" name="myform" v-form>
                
                <div class="panel-body">

                    <div class="form-group" v-validation-help>
                        <label for="email" class="model_label">{{ trans('general.email') }}</label>
                        <div class="model_input">
                            <input class="form-control"
                                   name="email" id="email"
                                   type="email"
                                   v-model="user.email"
                                   v-form-ctrl
                                   required
                            >
                        </div>
                    </div>

                </div>

                <div class="panel-footer text-right">

                    <button type="button" class="btn btn-default" @click="goBack" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="button" class="btn btn-default" @click="goBack" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptSendResetLink">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.send') }}
                    </button>
                    
                </div>

            </form>
            
            <div v-if="done">

                {{ trans('auth.password_reset_ok'); }}

            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import ValidationHelp from '../../directives/ValidationHelp.vue'
    import IsEqual from '../../directives/IsEqual.vue'

    export default {

        name: 'PasswordReset',

        directives: { ValidationHelp, IsEqual },

        data: function () {
            return {
                user: {
                    email: null,
                    password: null,
                    password_confirmation: null,
                    token: null
                },
                done: false,
                myform: []
            }
        },

        methods: {

            attemptResetPassword() {

                if(this.myform.$valid)
                    this.resetPassword();

            },

            resetPassword() {

                var self = this;

                client({ path: '/auth/reset', entity: self.user, method: 'POST'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('auth.password_reset_ok'),
                            options: {theme: 'success'}
                        });
                        //self.done = true;

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('auth.password_reset_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            },

            attemptSendResetLink() {

                if(this.myform.$valid)
                    this.sendResetLink();

            },

            sendResetLink() {

                var self = this;

                client({ path: '/auth/recovery', entity: self.user, method: 'POST'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('auth.mail_password_reset_ok'),
                            options: {theme: 'success'}
                        });
                        //self.done = true;

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('auth.mail_password_reset_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function(){

            this.user.token = this.$route.params.token || null;
            
            this.user.email = this.$route.params.email || null;
            console.log(this.$route)
        }

    }
</script>
