<template>

    <div class="panel-heading">
        {{ category.name }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <form v-if="isOwner(category)" class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateCategory" name="myform" v-form>

                <!-- TODO: Need to fix some styling and translation -->
                <div class="errors" v-if="myform.$submitted">
                    <p v-if="myform.name.$error.required">Name is required.</p>
                </div>

                <div class="form-group">
                    <label for="name" class="model_label">{{ trans('general.name') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="name" id="name"
                               type="text"
                               v-model="category.name"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <div class="model_action">
                        <template v-if="$root.history.previous && $root.history.previous.indexOf('show')>0">
                            <button type="button" class="btn" @click="goUp" v-if="myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                            </button>
                            <button type="button" class="btn" @click="goUp" v-if="!myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                            </button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                            </button>
                            <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                            </button>
                        </template>
                        <button type="submit" @keydown.enter.prevent="attemptUpdateCategory" class="btn btn-primary" :disabled="myform.$invalid">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>

            </form>

            <screen-list :screens="category.screens.data" from="categories">
            </screen-list>

        </div>

    </div>

</template>

<script>
    import Auth from '../../mixins/Auth.vue';
    import ScreenList from '../../components/ScreenList.vue';
    import SweetAlert from '../../mixins/SweetAlert.vue';

    export default {

        mixins: [Auth, SweetAlert],
        components: {ScreenList},

        data: function () {
            return {
                category: {
                    id: null,
                    name: null,
                    screens: null
                },
                myform: []
            }
        },

        methods: {
            fetch: function (id, successHandler) {
                var that = this
                client({ path: '/categories/' + id }).then(
                    function (response) {
                        that.$set('category', response.entity.data)
                        successHandler(response.entity.data)
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut')
                        } else {
                            console.log(response)
                        }
                    }
                )
            },

            attemptUpdateCategory() {
                if(this.myform.$valid) {
                    this.updateCategory()
                }
            },

            updateCategory() {
                var self = this
                client({ path: '/categories/' + self.category.id, entity: self.category, method: 'PUT'}).then(
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('category.updated'),
                            options: {theme: 'success'}
                        })
                        self.$route.router.go('/categories')
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('category.updated_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            },

            attemptDeleteScreen(index) {
                this.confirm({
                    callback:this.deleteScreen, arg:index,
                    text: this.trans('category.remove_association')
                })
            },

            deleteScreen(index) {
                var self = this;
                client({ path: '/categories/' + self.category.id + '/screen/' + self.category.screens.data[index].id, method: 'DELETE' }).then(
                        function (response) {
                            self.category.screens.data.splice(index, 1);
                            self.$dispatch('alert', {
                                message: self.trans('category.screen_association_removed'),
                                options: {theme: 'success'}
                            })
                        },
                        function (response) {
                            self.$dispatch('alert', {
                                message: self.trans('category.screen_association_removed_fail'),
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
        },

        route: {
            data: function (transition) {
                this.fetch(this.$route.params.id, function (data) {
                    transition.next({category: data})
                })
            }
        }
    }
</script>
