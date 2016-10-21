<template>

    <div class="panel-heading">
        {{ trans('auth.profile') }}
    </div>

    <form class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateMe" name="myform" v-form v-if="$root.store.user">

        <div class="panel-body">

            <div class="form-group">
                <label for="name" class="model_label">{{ trans('general.name') }}</label>
                <div class="model_data">
                    {{ $root.store.user.name }}
                </div>
            </div>

            <div class="form-group" v-validation-help>
                <label for="email" class="model_label">{{ trans('general.email') }}</label>
                <div class="model_data" v-show="!editUser">
                    {{ $root.store.user.email }}
                </div>
                <div class="model_input" v-show="editUser">
                    <input class="form-control"
                           name="email" id="email"
                           type="email"
                           v-model="user.email"
                           v-form-ctrl
                           v-is-unique:user
                           autocomplete="off"
                    >
                </div>
            </div>

            <div class="form-group" v-validation-help>
                <label for="password" class="model_label">{{ trans('auth.password') }}</label>
                <div class="model_data" v-show="!editUser">
                    ***
                </div>
                <div class="model_input" v-show="editUser">
                    <input class="form-control"
                           name="password" id="password"
                           type="password"
                           v-model="user.password"
                           v-form-ctrl
                           autocomplete="off"
                    >
                </div>
            </div>

        </div>

        <div class="panel-footer text-right" v-show="editUser">
            <button type="button" class="btn btn-default" @click="editUser = false" v-if="myform.$pristine">
                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
            </button>
            <button type="button" class="btn btn-default" @click="editUser = false" v-if="!myform.$pristine">
                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
            </button>
            <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptUpdateMe">
                <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
            </button>
        </div>

        <div class="panel-footer text-right" v-show="!editUser">
            <button v-if="!editUser" class="btn btn-default" @click="editUser = true">
                <span class="fa fa-pencil"></span> {{ trans('general.edit') }}
            </button>
        </div>

    </form>

</template>

<script type="text/ecmascript-6">
    import IsUnique from '../../directives/IsUnique.vue'
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {
        
        name: 'Profile',

        directives: { IsUnique, ValidationHelp },

        data: function(){
            return {
                user: {
                    email: '',
                    password: ''
                },
                myform: [],
                editUser: false
            }
        },

        methods: {

            attemptUpdateMe() {

                if(this.myform.$valid)
                    this.updateMe();

            },

            updateMe() {

                var self = this;

                client({ path: '/profile', entity: self.user, method: 'PUT'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('user.updated'),
                            options: {theme: 'success'}
                        });

                        // Refresh profile-data
                        self.$dispatch('userHasUpdatedProfile');

                        // Done editing
                        self.editUser = false;

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

        ready: function(){
            // Use vm.$set to trigger DOM-update on the inputs and prevent autocomplete
            this.$set('user.email', this.$root.store.user.email);
            this.$set('user.password', '');
        }

    }
</script>
