<template>

    <div class="panel-heading">
        {{ screengroup.name }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>
     
        <div class="panel-body">

            <form v-if="$root.isAdmin" v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateScreengroup">

                <div class="form-group" v-validation-help>
                    <label for="name" class="model_label">{{ trans('general.name') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="name" id="name"
                               type="text"
                               v-model="screengroup.name"
                               v-form-ctrl
                               v-is-unique:screengroup
                               required
                        >
                    </div>
                </div>
                <div class="form-group" v-validation-help>
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
                            <button type="button" class="btn btn-default" @click="goUp" v-if="myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                            </button>
                            <button type="button" class="btn btn-default" @click="goUp" v-if="!myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                            </button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-default" @click="goBack" v-if="myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                            </button>
                            <button type="button" class="btn btn-default" @click="goBack" v-if="!myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                            </button>
                        </template>
                        <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptUpdateScreengroup">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>

            </form>

            <screens :screens.sync="screengroup.screens.data" :id="screengroup.id"></screens>
            <tickers :tickers.sync="screengroup.tickers.data" :id="screengroup.id"></tickers>
            <clients :clients.sync="screengroup.clients.data" :id="screengroup.id"></clients>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import Screens from './screens.vue'
    import Tickers from './tickers.vue'
    import Clients from './clients.vue'
    import IsUnique from '../../directives/IsUnique.vue'
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {

        name: 'Show',

        directives: { IsUnique, ValidationHelp },

        components: { Screens, Tickers, Clients },

        data: function () {
            return {
                screengroup: {
                },
                myform: []
            }
        },

        methods: {

            fetch(id) {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/screengroups/' + id }).then(
                    
                    function (response) {

                        self.$set('screengroup', response.entity.data);

                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                    }

                );

            },

            attemptUpdateScreengroup() {

                if(this.myform.$valid)
                    this.updateScreengroup();

            },

            updateScreengroup() {

                var self = this;

                client({ path: '/screengroups/' + self.screengroup.id, entity: self.screengroup, method: 'PUT'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated'),
                            options: {theme: 'success'}
                        });

                        self.$route.router.go('/screengroups');

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated_fail'),
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
