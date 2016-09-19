<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>
        <screen-list :screens="screens" from="screen"></screen-list>
    </div>

</template>

<script type="text/ecmascript-6">
    import ScreenList from '../../components/ScreenList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { ScreenList },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                screens: []
            }
        },

        methods: {

            attemptDeleteScreen(screen) {

                this.confirm({
                    callback:this.deleteScreen, arg:screen,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteScreen(screen) {

                var self = this;

                client({ path: '/screens/' + screen.id, method: 'DELETE' }).then(

                    function (response) {

                        screen.removed = true;
                        self.screens.reverse();

                        self.$dispatch('alert', {
                            message: self.trans('screen.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screen.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function() {
            this.$on('remove-screen', function (screen) {
                this.attemptDeleteScreen(screen);
            });
        },

        route: {
            data: function (transition) {
                client({ path: '/screens' }).then(
                    function (response) {
                        transition.next({screens: response.entity.data});
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
