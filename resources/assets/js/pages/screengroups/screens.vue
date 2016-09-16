<template>

    <screen-list :screens="screens" from="screengroup"></screen-list>

</template>

<script type="text/ecmascript-6">
    import ScreenList from '../../components/ScreenList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'SG_Screen',

        props: [ 'screens', 'id' ],

        components: { ScreenList },

        mixins: [ SweetAlert ],

        methods: {

            attemptDeleteScreen(screen) {

                this.confirm({
                    callback:this.deleteScreen, arg:screen,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteScreen(screen) {

                var self = this;

                client({ path: '/screengroups/' + self.id + '/screen/' + screen.id, method: 'DELETE' }).then(
                    
                    function (response) {

                        screen.removed = true;
                        self.screens.reverse();

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.screen_association_removed'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.screen_association_removed_fail'),
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
        }

    }
</script>
