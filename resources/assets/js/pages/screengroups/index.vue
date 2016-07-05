<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if="screengroups.length == 0 ">
            {{ trans('screengroup.empty') }}
        </div>

        <table class="table" v-if=" screengroups.length > 0 ">
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
                    <td><a v-link="{ path: '/screengroups/'+screengroup.id }">{{ screengroup.name }}</a></td>
                    <td>{{ screengroup.desc }}</td>
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-eye " href="/play?mac={{screengroup.preview}}&preview=yes" target="_blank"
                           v-tooltip data-original-title="{{ trans('general.preview') }}" :disabled="hasPreview($index)"></a>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-if="isAdmin" v-link="{ path: '/screengroups/'+screengroup.id }"
                           v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-if="isAdmin" v-on:click="attemptDeleteScreengroup($index)"
                           v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script type="text/ecmascript-6">
    import SweetAlert from '../../mixins/SweetAlert.vue'
    import Auth from '../../mixins/Auth.vue'

    export default {

        name: 'Index',

        mixins: [ SweetAlert, Auth ],

        data: function () {
            return {
                screengroups: []
            }
        },

        methods: {

            hasPreview(index) {

                return this.screengroups[index].preview === '';

            },

            fetch(successHandler) {

                var self = this;

                client({ path: '/screengroups' }).then(

                    function (response) {

                        self.$set('screengroups', response.entity.data);
                        successHandler(response.entity.data);

                    },

                    function (response) {

                        console.log(response);

                    }

                );

            },

            attemptDeleteScreengroup(index) {

                this.confirm({
                    callback:this.deleteScreengroup, arg:index,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteScreengroup(index) {

                var self = this;

                client({ path: '/screengroups/' + self.screengroups[index].id, method: 'DELETE' }).then(
                    
                    function (response) {

                        self.screengroups.splice(index, 1);

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screengroups: data});
                });
            }
        }

    }
</script>
