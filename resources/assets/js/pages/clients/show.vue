<template>

    <div class="panel-heading">
        {{ trans('client.edit') }}
    </div>
    
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <form class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateClient" v-form name="myform">

            <div class="panel-body">

                <div class="form-group" v-validation-help>
                    <label for="name" class="model_label">{{ trans('general.name') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               id="name" name="name"
                               type="text"
                               v-model="client.name"
                               v-form-ctrl
                               v-is-unique:client
                               required
                        >
                    </div>
                </div>

                <div class="form-group" v-validation-help>
                    <label for="ip_address" class="model_label">{{ trans('general.mac_address') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               id="address" name="address"
                               type="text"
                               v-model="client.address"
                               v-form-ctrl
                               required
                               custom-validator="isMacAddress"
                        >
                    </div>
                </div>
                    
                <div class="form-group">
                    <span v-form-ctrl="client.screen_group_id" name="screengroup" required>
                        <model-selector :selected.sync="client.screen_group_id"
                                        model="screengroup"
                                        classes="model_input"
                        >
                            <div slot="label">
                                <label for="inputModels" class="model_label">
                                    {{ trans('screengroup.model',1) }}
                                </label>
                            </div>
                        </model-selector>
                    </span>
                </div>

            </div>

            <div class="panel-footer text-right">

                <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                    <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                </button>
                <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                    <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                </button>
                <button type="submit" @keydown.enter.prevent="attemptUpdateClient" class="btn btn-primary">
                    <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                </button>
                
            </div>

        </form>

    </div>
    
</template>

<script type="text/ecmascript-6">
    import ModelSelector from '../../components/ModelSelector.vue'
    import Validators from '../../mixins/Validators.vue'
    import IsUnique from '../../directives/IsUnique.vue'
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {

        name: 'Show',

        mixins: [ Validators ],

        components: { ModelSelector },

        directives: { IsUnique, ValidationHelp },

        data: function () {
            return {
                client: {
                    id: null,
                    name: null,
                    address: null,
                    screen_group_id: null
                },
                myform: []
            }
        },

        methods: {

            fetch(id, successHandler) {

                var self = this;

                client({ path: '/clients/' + id }).then(

                    function (response) {

                        self.$set('client', response.entity.client);
                        successHandler(response.entity.client);

                    },

                    function (response) {

                        console.log(response);

                    }

                );

            },

            attemptUpdateClient() {

                if(this.myform.$valid)
                    this.updateClient();

            },

            updateClient() {

                var self = this;

                client({ path: '/clients/' + self.client.id, entity: self.client, method: 'PUT'}).then(
                    
                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('client.updated'),
                            options: {theme: 'success'}
                        });

                        self.$route.router.go('/clients');

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('client.updated_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function(data) {
                    transition.next({client: data});
                });
            }
        }

    }
</script>