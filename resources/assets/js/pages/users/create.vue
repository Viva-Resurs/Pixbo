<template>
    <div class="panel-heading">
        {{ trans('user.create') }}
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" v-on:submit="createUser">
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

            <model-selector :selected.sync="user.roles" :model="model"></model-selector>

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
</template>

<script>
    import ModelSelector from '../../components/ModelSelector.vue'

    module.exports = {
        data: function () {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    roles: null
                },
                model: 'role',
                creating: false
            }
        },
        components: {
          ModelSelector
        },

        computed: {
          isValid() {
              // TODO: Add validation!
              return true
          }
        },

        methods: {
            createUser: function (e) {
                e.preventDefault()
                var that = this
                that.creating = true
                client({path: 'users', entity: that.user}).then(
                    function (response, status) {
                        that.user.name = ''
                        that.user.email = ''
                        that.user.password = ''
                        that.user.roles = null
                        that.$dispatch('alert', {
                            message: that.trans('user.created'),
                            options: {theme: 'success'}
                        })
                        Vue.nextTick(function () {
                            document.getElementById('nameInput').focus()
                        })
                        that.creating = false
                    },
                    function (response, status) {
                        that.$dispatch('alert', {
                            message: that.trans('user.created_fail'),
                            options: {theme: 'error'}
                        })
                        /*
                        that.messages = []
                        for (var key in response.entity) {
                            that.messages.push({type: 'danger', message: response.entity[key]})
                            that.creating = false
                        }
                        */
                    }
                )
            }
        }
    }
</script>

