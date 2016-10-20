<template>

    <div class="panel-heading">
        {{ trans('general.log') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>

        <activity-log :activitylog="activitylog"></activity-log>
        
    </div>

</template>

<script type="text/ecmascript-6">
    import ActivityLog from '../../components/ActivityLog.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { ActivityLog },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                activitylog: []
            }
        },

        methods: {

            attemptDeleteActivity(activity) {

                this.confirm({
                    callback: this.deleteActivity, arg:activity,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteActivity(activity) {

                var self = this;

                client({ path: '/activity/' + activity.id, method: 'DELETE' }).then(

                    function (response) {

                        activity.removed = true;
                        self.activitylog.reverse(); // Force vue to update view
                        
                        self.$dispatch('alert', {
                            message: self.trans('general.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('general.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function() {
            this.$on('remove-activity', function (activity) {
                this.attemptDeleteActivity(activity);
            })
        },

        route: {
            data: function (transition) {
                client({ path: '/activity' }).then(
                    function (response) {
                        transition.next({activitylog: response.entity.data});
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
