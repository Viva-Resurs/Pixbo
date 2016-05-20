<template>

    <div class="panel-heading">
        {{ trans('screengroup.create') }}
    </div>

    <div>
        <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptCreateScreengroup">

            <!-- TODO: Need to fix some styling and translation -->
            <div class="errors" v-if="myform.$submitted">
                <p v-if="myform.name.$error.required">Name is required.</p>
                <p v-if="myform.desc.$error.required">Description is required.</p>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="control-label">{{ trans('general.name') }}</label>
                    <div>
                        <input class="form-control"
                               name="name" id="name"
                               type="text"
                               v-model="screengroup.name"
                               v-form-ctrl
                               required
                               minlength="4"
                               maxlength="30"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class="control-label">{{ trans('general.desc') }}</label>
                    <div>
                        <input class="form-control"
                               name="desc" id="desc"
                               type="text"
                               v-model="screengroup.desc"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="" class="btn" v-link="{ path: '/screengroups/' }" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="" class="btn" v-link="{ path: '/screengroups/' }" v-if="!myform.$pristine">
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
    module.exports = {
        data: function () {
            return {
                screengroup: {
                    name: '',
                    desc: ''
                },
                myform: []
            }
        },

        methods: {
            attemptCreateScreengroup() {
                if(this.myform.$valid) {
                    this.createScreengroup();
                }
            },

            createScreengroup: function () {
                var self = this;
                client({path: 'screengroups', entity: this.screengroup}).then(
                    function (response, status) {
                        self.screengroup.name = '';
                        self.screengroup.desc = '';
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.created'),
                            options: {theme: 'success'}
                        })
                        self.$route.router.go('/screengroups')
                    },
                    function (response, status) {
                        self.$dispatch('alert', {
                            message: self.trans('screengroup.created_fail'),
                            options: {theme: 'error'}
                        })
                    }
                );
            }
        }
    }
</script>