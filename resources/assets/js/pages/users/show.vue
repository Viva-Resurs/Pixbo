<template>

    <div class="panel-heading">
        {{ trans('user.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <form class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateUser" name="myform" v-form>
            
            <div class="panel-body">

                <div class="form-group" v-validation-help>
                    <label for="name" class="model_label">{{ trans('general.name') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="name" id="name"
                               type="text"
                               v-model="user.name"
                               v-form-ctrl
                               v-is-unique:user
                               required
                        >
                    </div>
                </div>

                <div class="form-group" v-validation-help>
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

                <div class="form-group" v-validation-help>
                    <label for="password" class="model_label">{{ trans('auth.password') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="password" id="password"
                               type="password"
                               v-model="user.password"
                               v-form-ctrl
                        >
                    </div>
                </div>

                <div class="form-group">
                    <span v-form-ctrl="user.roles.data[0].id" name="roles" required>
                        <model-selector :selected.sync="user.roles.data[0].id" model="role" classes="model_input">
                            <div slot="label">
                                <label for="inputModels" class="model_label">
                                    {{ trans('role.model') }}
                                </label>
                            </div>
                        </model-selector>
                    </span>
                </div>

            </div>

            <div class="panel-footer text-right">

                <button type="button" class="btn btn-default" @click="goBack" v-if="myform.$pristine">
                    <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                </button>
                <button type="button" class="btn btn-default" @click="goBack" v-if="!myform.$pristine">
                    <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                </button>
                <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptUpdateUser">
                    <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                </button>
                
            </div>

        </form>

    </div>

</template>

<script type="text/ecmascript-6">
    import ModelSelector from '../../components/ModelSelector.vue'
    import IsUnique from '../../directives/IsUnique.vue'
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {

        name: 'Show',

        components: { ModelSelector },

        directives: { IsUnique, ValidationHelp },

        data: function () {
            return {
                user: {
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    roles: null
                },
                myform: []
            }
        },

        methods: {

            fetch(id) {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/users/' + id }).then(

                    function (response) {

                        self.$set('user', response.entity.data);

                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                    }

                );

            },

            attemptUpdateUser() {

                if(this.myform.$valid)
                    this.updateUser();

            },

            updateUser() {

                var self = this;

                client({ path: '/users/' + self.user.id, entity: self.user, method: 'PUT'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('user.updated'),
                            options: {theme: 'success'}
                        });

                        self.$route.router.go('/users');

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('user.updated_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        created: function(){
            this.fetch(this.$route.params.id);
        }

    }
</script>
