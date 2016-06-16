<template>

    <div class="panel-heading">
        {{ trans('client.create') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptCreate">

                <!-- TODO: Need to fix some styling and translation -->
                <div class="errors" v-if="myform.$submitted">
                    <p v-if="myform.name.$error.required">Name is required.</p>
                    <p v-if="myform.address.$error.required">MAC Address is required.</p>
                    <p v-if="myform.address.$error.customValidator">MAC Address is not valid.</p>
                    <p v-if="myform.screengroup.$error.required">Screengroup is required.</p>
                </div>

                <div class="form-group">
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

                <div class="form-group">
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

                <div class="form-group">
                    <div class="model_action">
                        <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                        </button>
                        <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                        </button>
                        <button type="submit" @keydown.enter.prevent="attemptCreate" class="btn btn-primary" :disabled="myform.$invalid">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import RouterHelpers from '../../mixins/RouterHelpers.vue';
    import ModelSelector from '../../components/ModelSelector.vue';
    import Validators from '../../mixins/Validators.vue';
    import IsUnique from '../../directives/IsUnique.vue';

    // TODO: Need to add unique validation

    module.exports = {
        mixins: [Validators, RouterHelpers],
        components: { ModelSelector },
        directives: { IsUnique },

        data: function () {
            return {
                client: {
                    name: '',
                    ip_address: '',
                    screen_group_id: null
                },
                myform: [],
                creating: false,
            }
        },

        methods: {
            attemptCreate() {
                if(this.myform.$valid) {
                    this.createClient();
                }
            },

            createClient: function () {

                var self = this;
                self.creating = true
                client({path: 'clients', entity: self.client}).then(
                    function (response, status) {
                        self.client.name = ''
                        self.client.address = ''
                        self.client.screengroup_id = ''
                        self.$dispatch('alert', {
                            message: self.trans('client.created'),
                            options: {theme: 'success'}
                        })
                        self.creating = false
                        self.goBack();
                    },
                    function (response, status) {
                        self.$dispatch('alert', {
                            message: self.trans('client.created_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        },
        created() {
            if ( this.$route.query.screengroup ){
                console.log(this.$route.query.screengroup);
                this.client.screen_group_id = this.$route.query.screengroup;
            }
        }
    }
</script>

