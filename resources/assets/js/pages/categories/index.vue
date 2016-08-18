<template>

    <div class="panel-heading">
        {{ trans('general.archive') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body" v-if=" categories.length == 0 ">
            {{ trans('category.empty') }}
        </div>

        <table class="table" v-if=" categories.length > 0 ">
            <thead>
                <tr>
                    <th>{{ trans('general.id') }}</th>
                    <th>{{ trans('general.name') }}</th>
                    <th>{{ trans('screen.model', 2) }}</th>
                    <th width="120px">{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>{{ category.id }}</td>
                    <td><a v-link="{ path: '/categories/'+category.id }">{{ category.name }}</a></td>
                    <td>{{ category.numberOfScreens }}</td>
                    <td>
                        <a class="btn btn-primary btn-xs fa fa-pencil" v-if="category.id !== 1 && isOwner(category)"
                            v-link="{ path: '/categories/'+category.id }"
                            v-tooltip data-original-title="{{ trans('general.edit') }}"></a>
                        <a class="btn btn-primary btn-xs fa fa-times" v-if="category.id !== 1 && isOwner(category)"
                            v-on:click="attemptDeleteCategory($index)"
                            v-tooltip data-original-title="{{ trans('general.delete') }}"></a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script type="text/ecmascript-6">
    import SweetAlert from '../../mixins/SweetAlert.vue'
    import Auth from '../../mixins/Auth.vue'

    export default {

        name: 'Index',

        mixins: [ SweetAlert, Auth ],

        data: function () {
            return {
                categories: {
                    id: null,
                    name: null,
                    screens: null,
                    user_id: null
                }
            }
        },

        methods: {

            fetch() {

                var self = this;

                self.$loadingRouteData = true;

                client({ path: '/categories' }).then(

                    function (response) {

                        self.$set('categories', response.entity.data);
                        
                        self.$loadingRouteData = false;

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        self.$loadingRouteData = false;

                        if (!self.attempts || self.attempts < 3)

                            setTimeout(function(){

                                self.attempts = (self.attempts) ? self.attempts+1 : 1;
                                self.fetch();

                            },1000);

                    }

                );

            },

            attemptDeleteCategory(index) {

                this.confirm({
                    callback:this.deleteCategory, arg:index,
                    confirmButtonText: this.trans('confirm.confirmButtonText_Delete')
                });

            },

            deleteCategory (index) {

                var self = this;

                client({ path: '/categories/' + self.categories[index].id, method: 'DELETE' }).then(

                    function (response) {

                        self.categories.splice(index, 1);

                        self.$dispatch('alert', {
                            message: self.trans('category.deleted'),
                            options: {theme: 'success'}
                        });

                        self.$route.router.go({name:'categories.index'});
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

        created: function(){
            this.fetch();
        }

    }
</script>
