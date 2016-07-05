<template>

    <div class="panel-heading">
        {{ trans('category.create') }}
    </div>

    <div class="panel-body">

        <form class="form-horizontal" role="form" v-on:submit.prevent="attemptCreateCategory" name="myform" v-form>

            <div class="form-group" v-validation-help>
                <label for="name" class="model_label">{{ trans('general.name') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           name="name" id="name"
                           type="text"
                           v-model="category.name"
                           v-form-ctrl
                           v-is-unique:category
                           required
                           minlength="4"
                           maxlength="30"
                    >
                </div>
            </div>

            <div class="form-group">
                <div class="model_action">
                    <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" @keydown.enter.prevent="attemptCreateCategory" class="btn btn-primary">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>

        </form>

    </div>

</template>

<script type="text/ecmascript-6">
    import IsUnique from '../../directives/IsUnique.vue';
    import ValidationHelp from '../../directives/ValidationHelp.vue';

    export default {
        
        name: 'Create',

        directives: { IsUnique, ValidationHelp },

        data: function () {
            return {
                category: {
                    name: ''
                },
                myform: []
            }
        },

        methods: {

            attemptCreateCategory() {

                if(this.myform.$valid)
                    this.createCategory();

            },

            createCategory() {

                var self = this;

                client({path: 'categories', entity: self.category}).then(

                    function (response, status) {

                        self.$dispatch('alert', {
                            message: self.trans('category.created'),
                            options: {theme: 'success'}
                        });

                        self.category.name = '';

                        self.$route.router.go('/categories');

                    },

                    function (response, status) {

                        self.$dispatch('alert', {
                            message: self.trans('category.created_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        }

    }
</script>
