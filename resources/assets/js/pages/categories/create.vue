<template>
    <div class="panel-heading">
        {{ trans('category.create') }}
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" v-on:submit.prevent="attemptCreateCategory" name="myform" v-form>

            <!-- TODO: Need to fix some styling and translation -->
            <div class="errors" v-if="myform.$submitted">
                <p v-if="myform.name.$error.required">Name is required.</p>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 col-sm-offset-1 control-label">{{ trans('general.name') }}</label>
                <div class="col-sm-5">
                    <input class="form-control"
                           name="name" id="name"
                           type="text"
                           v-model="category.name"
                           v-form-ctrl
                           required
                           minlength="4"
                           maxlength="30"
                    >
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="" class="btn" v-link="{ path: '/categories/' }" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="" class="btn" v-link="{ path: '/categories/' }" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="myform.$invalid">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    // TODO: Need to fix unique validation

    export default {
        data: function () {
            return {
                category: {
                    name: ''
                },
                myform: [],
                creating: false
            }
        },

        methods: {
            attemptCreateCategory() {
              if(this.myform.$valid) {
                  this.createCategory()
              }
            },
            createCategory() {
                var that = this
                that.creating = true
                client({path: 'categories', entity: that.category}).then(
                    function (response, status) {
                        that.category.name = ''
                        that.$dispatch('alert', {
                            message: that.trans('category.created'),
                            options: {theme: 'success'}
                        })

                        that.creating = false
                        that.$route.router.go('/categories')
                    },
                    function (response, status) {
                        that.$dispatch('alert', {
                            message: that.trans('category.created_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        }
    }
</script>

