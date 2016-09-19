<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>
        <screengroup-list :screengroups="screengroups"></screengroup-list>
    </div>

</template>

<script type="text/ecmascript-6">
    import ScreengroupList from '../../components/ScreengroupList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { ScreengroupList },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                screengroups: []
            }
        },

        methods: {

            attemptDeleteScreengroup(screengroup) {

                this.confirm({
                    callback:this.deleteScreengroup, arg:screengroup,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteScreengroup(screengroup) {

                var self = this;

                client({ path: '/screengroups/' + screengroup.id, method: 'DELETE' }).then(
                    
                    function (response) {

                        screengroup.removed = true;
                        self.screengroups.reverse(); // Force vue to update view

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

        ready: function() {
            this.$on('remove-screengroup', function (screengroup) {
                this.attemptDeleteScreengroup(screengroup);
            });
        },

        route: {
            data: function (transition) {
                client({ path: '/screengroups' }).then(
                    function (response) {
                        transition.next({screengroups: response.entity.data});
                    },
                    function (response){
                        transition.next();
                        console.error(response.entity.error);
                    }
                );
            }
        }

    }
</script>
