<template>

    <div class="panel-heading">
        {{ trans('client.create') }}
    </div>

    <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptCreate">
        
        <div class="panel-body">

            <div class="form-group" v-validation-help>
                <label for="name" class="model_label">{{ trans('general.name') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           id="name"
                           name="name"
                           type="text"
                           v-model="client.name"
                           v-form-ctrl
                           v-is-unique:client
                           required
                    >
                </div>
            </div>

            <div class="form-group" v-validation-help>
                <label for="address" class="model_label">{{ trans('general.mac_address') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           id="address"
                           name="address"
                           type="text"
                           placeholder="hh:hh:hh:hh:hh:hh"
                           v-model="client.address"
                           v-form-ctrl
                           custom-validator="isMacAddress"
                           v-is-unique:client
                           required
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
                                {{ trans('screengroup.model') }}
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
            <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptCreate">
                <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
            </button>
            
        </div>

    </form>

</template>

<script type="text/ecmascript-6">
    import RouterHelpers from '../../mixins/RouterHelpers.vue'
    import ModelSelector from '../../components/ModelSelector.vue'
    import Validators from '../../mixins/Validators.vue'
    import IsUnique from '../../directives/IsUnique.vue'
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {
        
        name: 'Create',

        mixins: [ Validators, RouterHelpers ],

        components: { ModelSelector },

        directives: { IsUnique, ValidationHelp },

        data: function () {
            return {
                client: {
                    name: '',
                    adress: '',
                    screen_group_id: null
                },
                myform: []
            }
        },

        methods: {

            attemptCreate() {

                if(this.myform.$valid)
                    this.createClient();

            },

            createClient() {

                var self = this;

                client({path: 'clients', entity: self.client}).then(

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('client.created'),
                            options: {theme: 'success'}
                        })

                        self.client.name = '';
                        self.client.address = '';
                        self.client.screengroup_id = '';

                        self.goBack();

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('client.created_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        created : function() {
            if ( this.$route.query.screengroup )
                this.client.screen_group_id = this.$route.query.screengroup;
        }

    }
</script>
