<template>
    <div class="panel-heading">
        {{ trans('client.create') }}
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" v-on:submit="createClient">
            <div class="form-group">
                <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" id="name" name="name" type="text" v-model="client.name">
                </div>
            </div>
            <div class="form-group">
                <label for="ip_address" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.ip_address') }}</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" id="ip_address" name="ip_address" type="text" v-model="client.ip_address">
                </div>
            </div>

            <model-selector :selected.sync="client.screen_group_id" model="screengroup"></model-selector>

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
    </div></template>

<script>
    import ModelSelector from '../../components/ModelSelector.vue'

    module.exports = {
        data: function () {
            return {
                client: {
                    name: '',
                    ip_address: '',
                    screen_group_id: null
                },
                messages: [],
                creating: false
            }
        },

        components: {
            ModelSelector
        },

        computed: {
          isValid() {
              //TODO: create client validation
              // Check if name is valid and unique
              // Check if ip address is valid and unique
              // Check that a screengroup is selected
          }
        },

        methods: {

            createClient: function (e) {
                e.preventDefault()
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

