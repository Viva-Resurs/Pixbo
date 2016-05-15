<template>
    <div class="panel-heading">
        {{ trans('client.create') }}
    </div>
    <div class="panel-body">
        <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptCreate">

            <!-- TODO: Need to fix some styling and translation -->
            <div class="errors" v-if="myform.$submitted">
                <p v-if="myform.name.$error.required">Name is required.</p>
                <p v-if="myform.ip_address.$error.required">IP Address is required.</p>
                <p v-if="myform.ip_address.$error.customValidator">IP Address is not valid.</p>
                <p v-if="myform.screengroup.$error.required">Screengroup is required.</p>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                <div class="col-sm-5">
                    <input class="form-control"
                           id="name"
                           name="name"
                           type="text"
                           v-model="client.name"
                           v-form-ctrl
                           required
                    >
                </div>
            </div>
            <div class="form-group">
                <label for="ip_address" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.ip_address') }}</label>
                <div class="col-sm-5">
                    <input class="form-control"
                           id="ip_address"
                           name="ip_address"
                           type="text"
                           v-model="client.ip_address"
                           v-form-ctrl
                           required
                           custom-validator="isIPAddress"
                    >
                </div>
            </div>
            <span v-form-ctrl="client.screen_group_id" name="screengroup" required>
                <model-selector :selected.sync="client.screen_group_id" model="screengroup"></model-selector>
            </span>

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="" class="btn" v-link="{ path: '/clients/' }" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="" class="btn" v-link="{ path: '/clients/' }" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script type="text/ecmascript-6">
    import ModelSelector from '../../components/ModelSelector.vue'

    // TODO: Need to add unique validation

    module.exports = {
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

        components: {
            ModelSelector
        },

        methods: {

            isIPAddress: val => /^(?!0)(?!.*\.$)((1?\d?\d|25[0-5]|2[0-4]\d)(\.|$)){4}$/.test(val),

            attemptCreate() {
                if(this.myform.$valid) {
                    this.createClient();
                }
            },

            createClient: function () {

                var that = this
                that.creating = true
                client({path: 'clients', entity: this.client}).then(
                    function (response, status) {
                        that.client.name = ''
                        that.client.ip_address = ''
                        that.client.screengroup_id = ''
                        that.$dispatch('alert', {
                            message: that.trans('client.created'),
                            options: {theme: 'success'}
                        })
                        that.creating = false
                        that.$route.router.go('/clients')

                    },
                    function (response, status) {
                        /*
                         for (var key in response.entity.error.errors) {
                         that.$dispatch('alert', {message: response.entity.error.errors[key][0]})
                         that.creating = false
                         }
                         */
                        that.$dispatch('alert', {
                            message: that.trans('client.created_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        }
    }
</script>

