<template>

    <div class="panel-heading">
        {{ trans('user.create') }}
    </div>

    <div class="panel-body">

        <form class="form-horizontal" role="form" v-on:submit.prevent="attemptCreateUser" name="myform" v-form>

            <!-- TODO: Need to fix some styling and translation -->
            <div class="errors" v-if="myform.$submitted">
                <p v-if="myform.name.$error.required">Name is required.</p>
                <p v-if="myform.email.$error.required">E-mail is required.</p>
                <p v-if="myform.email.$error.email">E-mail is not valid.</p>
                <p v-if="myform.password.$error.required">Password is required.</p>
                <p v-if="myform.password.$error.minlength">Password is too short.</p>
            </div>

            <div class="form-group">
                <label for="name" class="model_label">{{ trans('general.name') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           name="name" id="name"
                           type="text"
                           v-model="user.name"
                           v-form-ctrl
                           v-is-unique:user
                           required
                           minlength="4"
                           maxlength="30"
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="model_label">{{ trans('general.email') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           name="email" id="email"
                           type="email"
                           v-model="user.email"
                           v-form-ctrl
                           v-is-unique:user
                           required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="model_label">{{ trans('auth.password') }}</label>
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

            <!-- TODO: Role validation doesn't work -->
            <!-- TODO: When refreshing page here, roles gets lost -->
            <div class="form-group">
                <span v-form-ctrl="user.roles.data" name="roles" required>
                    <model-selector :selected.sync="user.roles.data" model="role" classes="model_input">
                    <div slot="label">
                        <label for="inputModels" class="model_label">
                            {{ trans('role.model') }}
                        </label>
                    </div>
                </model-selector>
                </span>
            </div>

            <div class="form-group">
                <div class="model_action">
                    <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" @keydown.enter.prevent="attemptCreateUser" class="btn btn-primary" :disabled="myform.$invalid">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>
            
        </form>

    </div>

</template>

<script>
    import ModelSelector from '../../components/ModelSelector.vue'
    import IsUnique from '../../directives/IsUnique.vue';

    export default {

        components: { ModelSelector },
        directives: { IsUnique },
        
        data: function () {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    roles: {
                        data: 1
                    }
                },
                myform: []
            }
        },

        methods: {
            attemptCreateUser() {
                if(this.myform.$valid) {
                    this.createUser()
                }
            },
            createUser() {
                var self = this;
                client({path: 'users', entity: self.user}).then(
                    function (response, status) {
                        self.$dispatch('alert', {
                            message: self.trans('user.created'),
                            options: {theme: 'success'}
                        })
                        self.$route.router.go('/users')
                    },
                    function (response, status) {
                        self.$dispatch('alert', {
                            message: self.trans('user.created_fail'),
                            options: {theme: 'error'}
                        })
                        Vue.nextTick(function () {
                            document.getElementById('nameInput').focus()
                        })
                    }
                )
            }
        }
    }
</script>

