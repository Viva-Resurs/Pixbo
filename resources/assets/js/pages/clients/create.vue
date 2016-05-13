<template>
    <div class="panel-heading">
        Make a dog!
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
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

            <screengroup-selector :selected.sync="client.screen_group_id"></screengroup-selector>

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
    import ScreengroupSelector from '../../components/ScreengroupSelector.vue'

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
          ScreengroupSelector
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
                            that.messages = [ {type: 'success', message: 'Woof woof! Your screengroup was created'} ]
                            that.creating = false
                        },
                        function (response, status) {
                            that.messages = []
                            for (var key in response.entity) {
                                that.messages.push({type: 'danger', message: response.entity[key]})
                                that.creating = false
                            }
                        }
                )
            }
        }
    }
</script>

