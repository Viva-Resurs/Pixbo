<template>

    <div class="panel-heading">
        {{ trans('client.edit') }}
    </div>
    
    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <form class="form-horizontal" role="form" v-on:submit="updateClient" v-form name="myform">

                <!-- TODO: Need to fix some styling and translation -->
                <div class="errors" v-if="myform.$submitted">
                    <p v-if="myform.name.$error.required">Name is required.</p>
                    <p v-if="myform.ip_address.$error.required">IP Address is required.</p>
                    <p v-if="myform.ip_address.$error.customValidator">IP Address is not valid.</p>
                    <p v-if="myform.screengroup.$error.required">Screengroup is required.</p>
                </div>

                <div class="form-group">
                    <label for="name" class="model_label">{{ trans('general.name') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               id="name" name="name"
                               type="text"
                               v-model="client.name"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="ip_address" class="model_label">{{ trans('general.ip_address') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               id="ip_address" name="ip_address"
                               type="text"
                               v-model="client.ip_address"
                               v-form-ctrl
                               required
                               custom-validator="isIPAddress"
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

                <div class="form-group">
                    <div class="model_action">
                        <button type="" class="btn" @click="goBack" v-if="myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                        </button>
                        <button type="" class="btn" @click="goBack" v-if="!myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="myform.$invalid">
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
    import Validators from '../../mixins/Validators.vue'

    // TODO: Need to add unique validation

    module.exports = {
        mixins: [Validators],
        components: { ModelSelector },

        data: function () {
            return {
                client: {
                    id: null,
                    name: null,
                    ip_address: null,
                    screen_group_id: null
                },
                myform: []
            }
        },
        methods: {


            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/clients/' + id }).then(
                    function (response) {
                        that.$set('client', response.entity.client);
                        successHandler(response.entity.client);
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

            updateClient: function (e) {
                e.preventDefault()
                var that = this
                client({ path: '/clients/' + this.client.id, entity: this.client, method: 'PUT'}).then(
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('client.updated'),
                            options: {theme: 'success'}
                        })
                        that.$route.router.go('/clients')
                    },
                    function (response) {
                        that.$dispatch('alert', {
                            message: that.trans('client.updated_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function(data) {
                    transition.next({client: data})
                })
            }
        }
    }
</script>