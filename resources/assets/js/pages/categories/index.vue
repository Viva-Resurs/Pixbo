<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div class="panel-body" v-else>

        <div class="panel-section" v-if=" categories.length == 0 ">
            {{ trans('category.empty') }}
        </div>

        <div class="panel-section" v-if=" categories.length > 0 ">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ trans('general.name') }}</th>
                        <th class="slim">{{ trans('screen.model', 2) }}</th>
                        <th class="slim">{{ trans('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories">
                        <td><a v-link="{ path: '/categories/'+category.id }">{{ category.name }}</a></td>
                        <td class="slim">{{ category.numberOfScreens }}</td>
                        <td class="slim">
                            <a class="btn btn-primary btn-xs fa fa-pencil" v-if="category.id !== 1 && $root.isOwner(category)"
                                v-link="{ path: '/categories/'+category.id }"
                                v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                            <a class="btn btn-primary hover-danger btn-xs fa fa-times" v-if="category.id !== 1 && $root.isOwner(category)"
                                v-on:click="attemptDeleteCategory(category.id)"
                                v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    import SweetAlert from '../../mixins/SweetAlert.vue'

    export default {

        name: 'Index',

        mixins: [ SweetAlert ],

        data: function () {
            return {
                categories: []
            }
        },

        methods: {

            fetch(successHandler,errorHandler) {

                var self = this;

                client({ path: '/categories' }).then(
                    successHandler,
                    errorHandler
                );

            },

            attemptDeleteCategory(categoryID) {

                this.confirm({
                    callback:this.deleteCategory, arg:categoryID,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteCategory (categoryID) {

                var self = this;

                var removeIndex = -1;

                for (var i=0; i<self.categories.length ; i++)
                    if (self.categories[i].id == categoryID)
                        removeIndex = i;

                if (removeIndex==-1)
                    return self.$dispatch('alert', {
                        message: self.trans('category.deleted_fail'),
                        options: {theme: 'error'}
                    });

                client({ path: '/categories/' + categoryID, method: 'DELETE' }).then(

                    function (response) {

                        self.categories.splice(removeIndex, 1);

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

        route: {
            data: function (transition) {
                this.fetch(function (response) {
                    transition.next({categories: response.entity.data});
                },function (response){
                    transition.next();
                    console.error(response.entity.error);
                });
            }
        }

    }
</script>
