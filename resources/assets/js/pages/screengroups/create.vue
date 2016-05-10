<template>
    <div class="panel-heading">
        {{ trans('screengroup.create') }}
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
        <form class="form-horizontal" role="form" v-on:submit="createScreengroup">
            <div class="form-group">
                <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" name="name" type="text" v-model="screengroup.name" id="nameInput">
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
                    <button type="" class="btn" v-link="{ path: '/screengroups/' }" v-if="emptyfields">
                      <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="" class="btn" v-link="{ path: '/screengroups/' }" v-if="!emptyfields">
                      <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="emptyfields">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
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
            createScreengroup: function (e) {
                e.preventDefault();
                var self = this;
                client({path: 'screengroups', entity: this.screengroup}).then(
                        function (response, status) {
                            self.screengroup.name = '';
                            self.screengroup.desc = '';
                            self.messages.push({ type:'success', message:self.trans('screengroup.created') });
                            Vue.nextTick(function () {
                                document.getElementById('nameInput').focus();
                            })
                        },
                        function (response, status) {
                            self.messages = [];
                            for (var key in response.entity) {
                                self.messages.push({ type:'danger', message:response.entity[key] });
                            }
                        }
                );
            }
        }
    }
</script>

