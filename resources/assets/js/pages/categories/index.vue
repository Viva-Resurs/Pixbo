<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>
        <category-list :categories="categories"></category-list>
    </div>

</template>

<script type="text/ecmascript-6">
    import CategoryList from '../../components/CategoryList.vue'
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        components: { CategoryList },

        mixins: [ SweetAlert ],

        data: function () {
            return {
                categories: []
            }
        },

        methods: {

            attemptDeleteCategory(category) {

                this.confirm({
                    callback:this.deleteCategory, arg:category,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteCategory(category) {

                var self = this;

                client({ path: '/categories/' + category.id, method: 'DELETE' }).then(

                    function (response) {

                        category.removed = true;
                        self.categories.reverse(); // Force vue to update view

                        self.$dispatch('alert', {
                            message: self.trans('category.deleted'),
                            options: {theme: 'success'}
                        });

                    },

                    function (response) {

                        self.$dispatch('alert', {
                            message: self.trans('category.deleted_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        },

        ready: function() {
            this.$on('remove-category', function (category) {
                this.attemptDeleteCategory(category);
            });
        },

        route: {
            data: function (transition) {
                client({ path: '/categories' }).then(
                    function (response) {
                        transition.next({categories: response.entity.data});
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
