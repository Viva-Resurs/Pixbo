<template>

    <div class="panel-heading">
        {{ trans('screengroup.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>
        
        <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateScreengroup">

            <!-- TODO: Need to fix some styling and translation -->
            <div class="errors" v-if="myform.$submitted">
                <p v-if="myform.name.$error.required">Name is required.</p>
                <p v-if="myform.desc.$error.required">Description is required.</p>
            </div>
        
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="control-label">{{ trans('general.name') }}</label>
                    <div>
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
                    <label for="desc" class=" control-label">{{ trans('general.desc') }}</label>
                    <div>
                        <input class="form-control"
                               name="desc" id="desc"
                               type="text"
                               v-model="screengroup.desc"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>
            </div>

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

        <screens :screens.sync="screengroup.screens.data"></screens>
        <tickers :tickers.sync="screengroup.tickers.data"></tickers>

    </div>

</template>

<script>
    import screens from './screens.vue'
    import tickers from './tickers.vue'

    module.exports = {

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
                var that = this;
                client({ path: '/screengroups/' + id }).then(
                    function (response) {
                        that.$set('screengroup', response.entity.data);
                        successHandler(response.entity.data);
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut');
                        } else {
                            console.log(response);
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
                client({ path: '/screengroups/' + this.screengroup.id, entity: this.screengroup, method: 'PUT'}).then(
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated'),
                            options: {theme: 'success'}
                        })
                        self.$route.router.go('/screengroups')
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated_fail'),
                            options: {theme: 'error'}
                        })
                        /*
                        self.messages = [];
                        for (var key in response.entity) {
                            self.messages.push({type: 'danger', message: response.entity[key]});
                        }
                        */
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