<template>
    
    <div class="panel-heading">
        {{ trans('auth.password_reset') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <form v-if="!done" class="form-horizontal" role="form" v-on:submit.prevent="attemptResetPassword" name="myform" v-form>
            
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
                <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptResetPassword">
                    <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                </button>
                
            </div>

        </form>
        
        <div v-if="done">

            {{ trans('auth.password_reset_ok'); }}

        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import ValidationHelp from '../../directives/ValidationHelp.vue'
    
    export default {

        name: 'PasswordReset',

        directives: { ValidationHelp },

        data: function () {
            return {
                user: {
                    email: null
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

                client({ path: '/auth/recovery', entity: self.user, method: 'POST'}).then(
                    
                    function (response) {

                        self.done = true;

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('auth.password_reset_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        }

    }
</script>
