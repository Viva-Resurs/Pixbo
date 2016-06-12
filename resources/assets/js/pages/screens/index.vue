<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <screen-list :screens="screens"></screen-list>

    </div>

</template>

<script>
    import ScreenList from '../../components/ScreenList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    module.exports = {

        components: { ScreenList },
        mixins:[SweetAlert],

        data: function () {
            return {
                screens: []
            }
        },

        methods: {
            fetch: function (successHandler) {
                var that = this
                client({ path: '/screens' }).then(
                    function (response) {
                        that.$set('screens', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status) {
                        console.log('logged out?')
                    }
                )
            },

            attemptDeleteScreen(index) {
                this.confirm({callback:this.deleteScreen, arg:index})
            },

            deleteScreen: function (index) {
                var self = this;
                client({ path: '/screens/' + this.screens[index].id, method: 'DELETE' }).then(
                    function (response) {
                        self.screens.splice(index, 1);
                        self.$dispatch('alert', {
                            message: self.trans('screen.deleted'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('screen.deleted_fail'),
                            options: {theme: 'error'}
                        })
                    }
                );
            }
        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({screens: data})
                })
            }
        },

        ready() {
            this.$on('remove-screen', function (index) {
                this.attemptDeleteScreen(index)
            })
        }
    }
</script>
