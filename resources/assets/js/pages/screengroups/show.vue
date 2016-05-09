<template>
    <div class="panel-heading">
        {{ trans('screengroup.edit') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div  v-if=" ! $loadingRouteData">
        <div class="panel-body">
            <div id="alerts" v-if="messages.length > 0">
                <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                    {{ message.message }}
                </div>
            </div>
            <form class="form-horizontal" role="form" v-on:submit="updateScreengroup">
                <fieldset disabled>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.id') }}</label>
                        <div class="col-sm-5">
                            <input class="form-control" required="required" name="name" type="text" v-model="screengroup.id">
                        </div>
                    </div>
                </fieldset>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="name" type="text" v-model="screengroup.name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.desc') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="desc" type="text" v-model="screengroup.desc">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-3">
                        <button type="" class="btn" v-link="{ path: '/screengroups/index' }">
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
    module.exports = {

        data: function () {
            return {
                screengroup: {
                },
                messages: []
            }
        },

        computed: {
             emptyfields: function(){
                return (this.screengroup.name=='' || this.screengroup.desc=='') ? true : false;
             }
        },

        methods: {
            // Let's fetch the screengroup
            fetch: function (id, successHandler) {
                var that = this;
                client({ path: '/screengroups/' + id }).then(
                        function (response) {
                            that.$set('screengroup', response.entity.data)
                            successHandler(response.entity.data)
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

            updateScreengroup: function (e) {
                e.preventDefault()
                var self = this
                client({ path: '/screengroups/' + this.screengroup.id, entity: this.screengroup, method: 'PUT'}).then(
                        function (response) {
                            self.messages = []
                            self.messages.push({type: 'success', message: self.trans('screengroup.updated')})
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
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({screengroup: data})
                })
            }
        }
    }
</script>