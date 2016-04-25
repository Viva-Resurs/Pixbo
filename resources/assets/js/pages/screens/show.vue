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
        <form class="form-horizontal" role="form" v-on:submit="updateScreen">
            <fieldset disabled>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-sm-offset-1 control-label">Screen ID</label>
                    <div class="col-sm-5">
                        <input class="form-control" required="required" name="name" type="text" v-model="screen.id">
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-save"></i>Update the screen!</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    module.exports = {

        data: function () {
            return {
                screen: {
                },
                messages: []
            }
        },

        methods: {
            // Let's fetch the screen
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/screens/' + id }).then(
                        function (response) {
                            that.$set('screen', response.entity.screen)
                           successHandler(response.entity.screen)
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
                client({ path: '/screens/' + this.screen.id, entity: this.screen, method: 'PUT'}).then(
                        function (response) {
                            self.messages = []
                            self.messages.push({type: 'success', message: 'Your screen was updated'})
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
                    transition.next({screen: data})
                })
            }
        }
    }
</script>