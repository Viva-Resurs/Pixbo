<template>
    <div class="panel-heading">
        {{ trans('user.edit') }}
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
        <div class="panel-body" v-if=" $loadingRouteData ">
            <loading></loading>
        </div>

        <div v-else>
            <form class="form-horizontal" role="form" v-on:submit="updateUser">
                <div class="form-group">
                    <label for="nameInput" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="name" type="text" v-model="user.name" id="nameInput">
                    </div>
                </div>

                <div class="form-group">
                    <label for="emailInput" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.email') }}</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" required="required" id="emailInput" name="email" v-model="user.email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="passwordInput" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('auth.password') }}</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" required="required" id="passwordInput" name="password" v-model="user.password">
                    </div>
                </div>

                <model-selector :selected.sync="user.roles" model="role"></model-selector>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-3">
                        <button type="" class="btn" v-link="{ path: '/clients/' }" v-if="emptyfields">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                        </button>
                        <button type="" class="btn" v-link="{ path: '/clients/' }" v-if="!emptyfields">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="emptyfields">
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

        data: function () {
            return {
                user: {
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    roles: null
                },
                messages: []
            }
        },

        components: {
            ModelSelector
        },

        computed: {
          isValid() {
              // TODO: Add validation for user update
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

            updateUser: function (e) {
                e.preventDefault()
                var self = this
                client({ path: '/users/' + this.user.id, entity: this.user, method: 'PUT'}).then(
                    function (response) {
                        self.messages = []
                        self.messages.push({type: 'success', message: self.trans('user.updated')})
                    },
                    function (response) {
                        self.messages = []
                        for (var key in response.entity) {
                            self.messages.push({type: 'danger', message: response.entity[key]})
                        }
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