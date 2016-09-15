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

            fetch() {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/screens/' }).then(

                    function (response) {

                        self.$set('screens', response.entity.data);

                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                    }

                );

            },

            attemptDeleteScreen(screenID) {

                this.confirm({
                    callback:this.deleteScreen, arg:screenID,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
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
                        message: self.trans('screen.deleted_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/screens/' + screenID, method: 'DELETE' }).then(

                    function (response) {

                        self.screens.splice(removeIndex, 1);

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
            this.$on('remove-screen', function (screenID) {
                this.attemptDeleteScreen(screenID);
            });
        },

        created: function(){
            this.fetch();
        }

    }
</script>
