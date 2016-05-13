<template>
    <div class="panel-heading">
        {{ trans('client.edit') }}
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>

        <div class="panel-body" v-if=" $loadingRouteData ">
            <loading></loading>
        </div>

        <div v-else>
            <form class="form-horizontal" role="form" v-on:submit="updateClient">
                <fieldset disabled>
                    <div class="form-group">
                        <label for="id" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.id') }}</label>
                        <div class="col-sm-5">
                            <input class="form-control" id="id" required="required" name="id" type="text" v-model="client.id">
                        </div>
                    </div>
                </fieldset>
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
        </div>
    </div>
</template>

<script>
    import ModelSelector from '../../components/ModelSelector.vue'

    module.exports = {

        data: function () {
            return {
                client: {
                    id: null,
                    name: null,
                    ip_address: null,
                    screen_group_id: null
                },
                messages: []
            }
        },

        components: {
            ModelSelector
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
                var self = this
                client({ path: '/clients/' + this.client.id, entity: this.client, method: 'PUT'}).then(
                    function (response) {
                        self.messages = []
                        self.messages.push({type: 'success', message: self.trans('client.updated')})
                    },
                    function (response) {
                        self.messages = []
                        for (var key in response.entity) {
                            self.messages.push({type: 'danger', message: response.entity[key]})
                        }
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