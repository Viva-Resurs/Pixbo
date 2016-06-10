/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <!-- TODO: Fix the styling of things-->
    <screen-list :screens="screens" from="screengroup"></screen-list>
</template>

<script type="text/ecmascript-6">
    import ScreenList from '../../components/ScreenList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {
        props: ['screens', 'id'],

        components: { ScreenList },
        mixins:[SweetAlert],

        methods: {
            attemptDeleteScreen(index) {
                // TODO: Fix text
                this.confirm({callback:this.deleteScreen, arg:index})
            },

            deleteScreen: function (index) {
                var self = this;
                client({ path: '/screengroups/' + this.id + '/screen/' + this.screens[index].id, method: 'DELETE' }).then(
                        function (response) {
                            self.screens.splice(index, 1);
                            self.$dispatch('alert', {
                                message: self.trans('screengroup.screen_association_removed'),
                                options: {theme: 'success'}
                            })
                        },
                        function (response) {
                            self.$dispatch('alert', {
                                message: self.trans('screengroup.screen_association_removed_fail'),
                                options: {theme: 'error'}
                            })
                        }
                );
            }
        },

        ready() {
            this.$on('remove-screen', function (index) {
                this.attemptDeleteScreen(index)
            })
        }
    }
</script>