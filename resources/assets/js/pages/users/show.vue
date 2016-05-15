<template>
    <div class="panel-heading">
        {{ trans('user.edit') }}
    </div>
    <div class="panel-body">
        <div class="panel-body" v-if=" $loadingRouteData ">
            <loading></loading>
        </div>

        <div v-else>
            <form class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateUser" name="myform" v-form>

                <!-- TODO: Need to fix some styling and translation -->
                <div class="errors" v-if="myform.$submitted">
                    <p v-if="myform.name.$error.required">Name is required.</p>
                    <p v-if="myform.email.$error.required">E-mail is required.</p>
                    <p v-if="myform.email.$error.email">E-mail is not valid.</p>
                    <p v-if="myform.password.$error.required">Password is required.</p>
                    <p v-if="myform.password.$error.minlength">Password is too short.</p>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control"
                               name="name" id="name"
                               type="text"
                               v-model="user.name"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.email') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control"
                               name="email" id="email"
                               type="email"
                               v-model="user.email"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('auth.password') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control"
                               name="password" id="password"
                               type="password"
                               v-model="user.password"
                               v-form-ctrl
                        >
                    </div>
                </div>
                <!-- TODO: This validation doesn't work -->
                <span name="roles" v-form-ctrl="user.roles.data[0].id" required>
                    <model-selector :selected.sync="user.roles.data[0].id" model="role"></model-selector>
                </span>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-3">
                        <button type="" class="btn" v-link="{ path: '/clients/' }" v-if="myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                        </button>
                        <button type="" class="btn" v-link="{ path: '/clients/' }" v-if="!myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="myform.$invalid">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import ModelSelector from '../../components/ModelSelector.vue'

    module.exports = {
        components: { ModelSelector },

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
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/users/' + id }).then(
                    function (response) {
                        console.log(response)
                        that.$set('user', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut')
                        } else {
                            console.log(response)
                        }
                    }
                )
            },

            attemptUpdateUser() {
                if(this.myform.$valid) {
                    this.updateUser()
                }
            },

            updateUser() {
                var self = this
                client({ path: '/users/' + self.user.id, entity: self.user, method: 'PUT'}).then(
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('user.updated'),
                            options: {theme: 'success'}
                        })
                        self.$route.router.go('/users')
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('user.updated_fail'),
                            options: {theme: 'error'}
                        })
                        /*self.messages = []
                        for (var key in response.entity) {
                            self.messages.push({type: 'danger', message: response.entity[key]})
                        }
                        */
                    }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({user: data})
                })
            }
        }
    }
</script>