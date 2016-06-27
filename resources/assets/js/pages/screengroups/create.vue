<template>

    <div class="panel-heading">
        {{ trans('screengroup.create') }}
    </div>

    <div class="panel-body">

        <form v-form name="myform" class="form-horizontal" role="form" v-on:submit.prevent="attemptCreateScreengroup">

            <!-- TODO: Need to fix some styling and translation -->
            <div class="errors" v-if="myform.$submitted">
                <p v-if="myform.name.$error.required">Name is required.</p>
                <p v-if="myform.desc.$error.required">Description is required.</p>
            </div>

            <div class="form-group">
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

            <div class="form-group">
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

            <div class="form-group">
                <div class="model_action">
                    <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                        <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" @keydown.enter.prevent="attemptCreateScreengroup" class="btn btn-primary" :disabled="myform.$invalid">
                        <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>

        </form>

    </div>

</template>

<script>
    import IsUnique from '../../directives/IsUnique.vue';
    
    export default {

        directives: { IsUnique },
        
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
                        self.$route.router.go('/screengroups/'+response.entity.data.id);
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