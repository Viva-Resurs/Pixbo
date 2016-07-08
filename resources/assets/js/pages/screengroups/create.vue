<template>

    <div class="panel-heading">
        {{ trans('screengroup.create') }}
    </div>

    <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptCreateScreengroup">

        <div class="panel-body">

            <div class="form-group" v-validation-help>
                <label for="name" class="model_label">{{ trans('general.name') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           name="name" id="name"
                           type="text"
                           v-model="screengroup.name"
                           v-form-ctrl
                           v-is-unique:screengroup
                           required
                           minlength="4"
                           maxlength="30"
                    >
                </div>
            </div>

            <div class="form-group" v-validation-help>
                <label for="desc" class="model_label">{{ trans('general.desc') }}</label>
                <div class="model_input">
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

        <div class="panel-footer text-right">

            <button type="button" class="btn btn-default" @click="goBack" v-if="myform.$pristine">
                <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
            </button>
            <button type="button" class="btn btn-default" @click="goBack" v-if="!myform.$pristine">
                <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
            </button>
            <button type="submit" class="btn btn-primary" @keydown.enter.prevent="attemptCreateScreengroup">
                <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
            </button>
            
        </div>

    </form>

</template>

<script type="text/ecmascript-6">
    import ValidationHelp from '../../directives/ValidationHelp.vue'
    import IsUnique from '../../directives/IsUnique.vue'

    export default {
        
        name: 'Create',

        directives: { IsUnique, ValidationHelp },
        
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

                if(this.myform.$valid)
                    this.createScreengroup();

            },

            createScreengroup() {

                var self = this;

                client({path: 'screengroups', entity: this.screengroup}).then(
                    
                    function (response, status) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.created'),
                            options: {theme: 'success'}
                        })

                        self.screengroup.name = '';
                        self.screengroup.desc = '';

                        self.$route.router.go('/screengroups/'+response.entity.data.id);

                    },

                    function (response, status) {

                        self.$dispatch('alert', {
                            message: self.trans('screengroup.created_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        }

    }
</script>
