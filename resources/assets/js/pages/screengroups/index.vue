<template>
    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>
    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>
    <div class="panel-body" v-if="messages.length > 0">
        <div v-for="message in messages" class="alert alert-{{ message.type }} alert-dismissible" role="alert">
            {{ message.message }}
        </div>
    </div>

    <div class="panel-body" v-if=" ! $loadingRouteData && screengroups.length == 0">
        {{ trans('screengroup.empty') }}
    </div>

    <table class="table" v-if=" ! $loadingRouteData && screengroups.length > 0">
        <thead>
            <tr>
                <th>{{ trans('general.id') }}</th>
                <th>{{ trans('general.name') }}</th>
                <th>{{ trans('general.desc') }}</th>
                <th width="120px">{{ trans('general.action') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="screengroup in screengroups">
                <td>{{ screengroup.id }}</td>
                <td>{{ screengroup.name }}</td>
                <td>{{ screengroup.desc }}</td>
                <td>
                    <a class="btn btn-primary btn-xs fa fa-pencil" v-link="{ path: '/screengroups/'+screengroup.id }"
                       v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                    <a class="btn btn-primary btn-xs fa fa-times" v-on:click="deleteScreengroup($index)"
                       v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    module.exports = {

        data: function () {
            return {
                screengroups: [],
                messages: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var self = this;
                client({ path: '/screengroups' }).then(
                        function (response) {
                            self.$set('screengroups', response.entity.data);
                            successHandler(response.entity.data);
                        },
                        function (response, status) {
                            if (_.contains([401, 500], status)) {
                                self.$dispatch('userHasLoggedOut');
                            }
                        }
                );
            },

            deleteScreengroup: function (index) {
                var self = this;
                client({ path: '/screengroups/' + this.screengroups[index].id, method: 'DELETE' }).then(
                        function (response) {
                            self.screengroups.splice(index, 1);
                            self.messages.push({ type:'success', message:self.trans('screengroup.deleted') });
                        },
                        function (response) {
                            self.messages.push({ type:'danger', message:self.trans('screengroup.deleted_fail') });
                        }
                );
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screengroups: data});
                })
            }
        }

    }
</script>
