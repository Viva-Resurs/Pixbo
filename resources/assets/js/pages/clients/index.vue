<template>
    <div class="panel-heading">
        List of screengroups
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if="screengroups.length == 0">
        You have no screengroups!
    </div>

    <table class="table" v-if=" ! $loadingRouteData && screengroups.length > 0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th width="120px">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="screengroup in screengroups">
            <td>{{ screengroup.id }}</td>
            <td>{{ screengroup.name }}</td>
            <td>{{ screengroup.age }}</td>
            <td>
                <a class="btn btn-primary btn-xs" v-link="{ path: '/screengroups/'+screengroup.id }">Edit</a>
                <a class="btn btn-primary btn-xs" v-on:click="deleteScreengroup($index)">Delete</a>
            </td>
        </tr>
        </tbody>
    </table></template>

<script>
    module.exports = {

        data: function () {
            return {
                screengroups: [],
                messages: []
            }
        },

        methods: {
            // Let's fetch some dogs
            fetch: function (successHandler) {
                var that = this
                client({ path: '/screengroups' }).then(
                        function (response) {
                            // Look ma! Puppies!
                            that.$set('screengroups', response.entity.data)
                            successHandler(response.entity.data)
                        },
                        function (response, status) {
                            if (_.contains([401, 500], status)) {
                                that.$dispatch('userHasLoggedOut')
                            }
                        }
                )
            },

            deleteScreengroup: function (index) {
                var that = this
                client({ path: '/screengroups/' + this.screengroups[index].id, method: 'DELETE' }).then(
                        function (response) {
                            that.screengroups.splice(index, 1)
                            that.messages = [{type: 'success', message: 'Great, screengroup purged.'}]
                        },
                        function (response) {
                            that.messages.push({type: 'danger', message: 'There was a problem removing the screengroup'})
                        }
                )
            }

        },

        route: {
            // Ooh, ooh, are there any new puppies yet?
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screengroups: data})
                })
            }
        }

    }
</script>
