<template>

    <div class="panel-heading">
        {{ trans('screengroup.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>
        
        <form class="form-horizontal" role="form" v-on:submit="updateScreengroup">
        
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="control-label">{{ trans('general.id') }}</label>
                    <div>
                        <input disabled class="form-control" required="required" name="name" type="text" v-model="screengroup.id">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">{{ trans('general.name') }}</label>
                    <div>
                        <input class="form-control" required="required" name="name" type="text" v-model="screengroup.name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class=" control-label">{{ trans('general.desc') }}</label>
                    <div>
                        <input class="form-control" required="required" name="desc" type="text" v-model="screengroup.desc">
                    </div>
                </div>
            </div>

            <div class="panel-footer text-right">
                <button type="" class="btn" v-link="{ path: '/screengroups/' }">
                  <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                </button>
                <button type="submit" class="btn btn-primary" :disabled="emptyfields">
                  <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                </button>
            </div>

        </form>

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
             },
            isValid() {
                // TODO: Add validation
            }
        },

        methods: {
            // Let's fetch the screengroup
            fetch: function (id, successHandler) {
                var that = this;
                client({ path: '/screengroups/' + id }).then(
                    function (response) {
                        that.$set('screengroup', response.entity.data);
                        successHandler(response.entity.data);
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut');
                        } else {
                            console.log(response);
                        }
                    }
                );
            },

            updateScreengroup: function (e) {
                e.preventDefault();
                var self = this;
                client({ path: '/screengroups/' + this.screengroup.id, entity: this.screengroup, method: 'PUT'}).then(
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.updated_fail'),
                            options: {theme: 'error'}
                        })
                        /*
                        self.messages = [];
                        for (var key in response.entity) {
                            self.messages.push({type: 'danger', message: response.entity[key]});
                        }
                        */
                    }
                );
            }

        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({screengroup: data});
                });
            }
        }
    }
</script>