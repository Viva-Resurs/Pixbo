<template>
    <div class="panel-heading">
        Edit screengroup
    </div>
    <div class="panel-body">
        <div id="alerts" v-if="messages.length > 0">
            <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
                {{ message.message }}
            </div>
        </div>
        <form class="form-horizontal" role="form" v-on:submit="updateScreengroup">
            <fieldset disabled>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-sm-offset-1 control-label">Screengroup ID</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="name" type="text" v-model="screengroup.id">
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-sm-offset-1 control-label">Name your screengroup</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" name="name" type="text" v-model="screengroup.name">
                </div>
            </div>
            <div class="form-group">
                <label for="age" class="col-sm-2 col-sm-offset-1 control-label">What's the age?</label>
                <div class="col-sm-5">
                    <input class="form-control" required="required" name="age" type="text" v-model="screengroup.desc">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-save"></i>Update the screengroup!</button>
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
                    id: null,
                    name: null,
                    age: null
                },
                messages: []
            }
        },

        methods: {
            // Let's fetch the screengroup
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/screengroups/' + id }).then(
                        function (response) {
                            that.$set('screengroup', response.entity.screengroup)
                           successHandler(response.entity.screengroup)
                        },
                        function (response, status, request) {
                            // Go tell your parents that you've messed up somehow
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
                            self.messages.push({type: 'success', message: 'Woof woof! Your screengroup was updated'})
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
            // Ooh, ooh, are there any new puppies yet?
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({screengroup: data})
                })
            }
        }
    }
</script>