<template>

    <div class="panel-heading">
        {{ screengroup.name }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>
     
        <div class="panel-body">

            <form v-if="isAdmin" v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateScreengroup">

                <!-- TODO: Need to fix some styling and translation -->
                <div class="errors" v-if="myform.$submitted">
                    <p v-if="myform.name.$error.required">Name is required.</p>
                    <p v-if="myform.desc.$error.required">Description is required.</p>
                </div>
            
                <div class="form-group">
                    <label for="name" class="model_label">{{ trans('general.name') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="name" id="name"
                               type="text"
                               v-model="screengroup.name"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class="model_label">{{ trans('general.desc') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="desc" id="desc"
                               type="text"
                               v-model="screengroup.desc"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <div class="model_action">
                        <template v-if="$root.history.previous && $root.history.previous.indexOf('show')>0">
                            <button type="button" class="btn" @click="goUp" v-if="myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                            </button>
                            <button type="button" class="btn" @click="goUp" v-if="!myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                            </button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                            </button>
                            <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                            </button>
                        </template>
                        <button type="submit" @keydown.enter.prevent="attemptUpdateScreengroup" class="btn btn-primary" :disabled="myform.$invalid">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>

            </form>

            <screens :screens.sync="screengroup.screens.data" :id="screengroup.id"></screens>
            <tickers :tickers.sync="screengroup.tickers.data" :id="screengroup.id"></tickers>

        </div>

    </div>

</template>

<script>
    import screens from './screens.vue'
    import tickers from './tickers.vue'
    import Auth from '../../mixins/Auth.vue'

    module.exports = {

        mixins:[Auth],
        components: {
            screens,
            tickers
        },

        data: function () {
            return {
                screengroup: {
                },
                myform: []
            }
        },

        methods: {
            fetch: function (id, successHandler) {
                var self = this;
                client({ path: '/screengroups/' + id }).then(
                    function (response) {
                        self.$set('screengroup', response.entity.data);
                        successHandler(response.entity.data);
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut');
                        } else {
                            self.$route.router.go('/screengroups');
                        }
                    }
                );
            },

            attemptUpdateScreengroup() {
                if(this.myform.$valid) {
                    this.updateScreengroup();
                }
            },

            updateScreengroup: function () {
                var self = this;
                client({ path: '/screengroups/' + self.screengroup.id, entity: self.screengroup, method: 'PUT'}).then(
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated'),
                            options: {theme: 'success'}
                        })
                        self.$route.router.go('/screengroups');
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated_fail'),
                            options: {theme: 'error'}
                        })
                    }
                );
            }

        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({screengroup: data});
                });
            }
        }
    }
</script>