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
                    <button type="submit" class="btn btn-primary" :disabled="creating">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div></template>

<script>
    module.exports = {
        data: function () {
            return {
                screengroup: {
                    name: '',
                    desc: ''
                },
                messages: [],
                creating: false
            }
        },

        methods: {
            createScreengroup: function (e) {
                e.preventDefault()
                var that = this
                that.creating = true
                client({path: 'screengroups', entity: this.screengroup}).then(
                        function (response, status) {
                            that.screengroup.name = ''
                            that.screengroup.desc = ''
                            that.messages = [ {type: 'success', message: trans('screengroup.created') } ]
                            Vue.nextTick(function () {
                                document.getElementById('nameInput').focus()
                            })
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

