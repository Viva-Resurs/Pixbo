<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

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

            fetch(successHandler) {

                var self = this;

                client({ path: '/screens' }).then(

                    function (response) {

                        self.$set('screens', response.entity.data);
                        successHandler(response.entity.data);

                    },

                    function (response) {

                        console.log(response);

                    }

                );

            },

            attemptDeleteScreen(index) {

                this.confirm({
                    callback:this.deleteScreen, arg:index,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteScreen(index) {

                var self = this;

                client({ path: '/screens/' + self.screens[index].id, method: 'DELETE' }).then(

                    function (response) {

                        self.screens.splice(index, 1);

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

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screens: data});
                });
            }
        },

        ready: function() {
            this.$on('remove-screen', function (index) {
                this.attemptDeleteScreen(index);
            });
        }

    }
</script>
