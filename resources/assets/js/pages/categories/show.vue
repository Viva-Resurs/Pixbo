<template>

    <div class="panel-heading" v-if="isOwner(category)">
        {{ trans('category.edit') }}
    </div>
    <div class="panel-heading" v-else>
        {{ trans('category.show') }}
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
                        <button type="" class="btn" @click="goBack" v-if="myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                        </button>
                        <button type="" class="btn" @click="goBack" v-if="!myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                        </button>
                        <button type="submit" v-on:keyup.enter="attemptUpdateCategory" class="btn btn-primary" :disabled="myform.$invalid">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>

            </form>

            <!-- Add some show screens component -->

            <screen-list :screens="category.screens.data" from="categories">
                
            </screen-list>

        </div>

    </div>

</template>

<script>
    import Auth from '../../mixins/Auth.vue';
    import ScreenList from '../../components/ScreenList.vue';

    export default {

        mixins:[Auth],
        components:{ScreenList},

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
                        console.log(response)
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
            }

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