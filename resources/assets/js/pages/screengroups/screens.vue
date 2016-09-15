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

            attemptDeleteScreen(screenID) {

                this.confirm({
                    callback:this.deleteScreen, arg:screenID,
                    text: this.trans('screengroup.remove_association')
                });

            },

            deleteScreen(screenID) {

                var self = this;

                var removeIndex = -1;

                for (var i=0; i<self.screens.length ; i++)
                    if (self.screens[i].id == screenID)
                        removeIndex = i;

                if (removeIndex==-1)
                    return self.$dispatch('alert', {
                        message: self.trans('screengroup.screen_association_removed_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/screengroups/' + self.id + '/screen/' + screenID, method: 'DELETE' }).then(
                    
                    function (response) {

                        self.screens.splice(removeIndex, 1);

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
            this.$on('remove-screen', function (screenID) {
                this.attemptDeleteScreen(screenID);
            });
        }

    }
</script>
