<template>

    <div class="panel-heading">
        {{ trans('screengroup.create') }}
    </div>

    <div>
        <form class="form-horizontal" role="form" v-on:submit="createScreengroup">

            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="control-label">{{ trans('general.name') }}</label>
                    <div>
                        <input class="form-control" required="required" name="name" type="text" v-model="screengroup.name" id="nameInput">
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class="control-label">{{ trans('general.desc') }}</label>
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
                    name: '',
                    desc: ''
                }
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
            createScreengroup: function (e) {
                e.preventDefault();
                var self = this;
                client({path: 'screengroups', entity: this.screengroup}).then(
                        function (response, status) {
                            self.screengroup.name = '';
                            self.screengroup.desc = '';
                            self.$dispatch('alert', {
                                message: self.trans('screengroup.created'),
                                options: {theme: 'success'}
                            })
                            Vue.nextTick(function () {
                                document.getElementById('nameInput').focus();
                            })
                        },
                        function (response, status) {
                            /*
                            for (var key in response.entity) {
                                self.messages.push({ type:'danger', message:response.entity[key] });
                            }
                            */
                            self.$dispatch('alert', {
                                message: self.trans('screengroup.created_fail'),
                                options: {theme: 'error'}
                            })
                        }
                );
            }
        }
    }
</script>