<template>

    <div class="panel-heading">
        {{ trans('ticker.create') }}
    </div>

    <div class="panel-body">

        <form class="form-horizontal" role="form" v-on:submit.prevent="attemptCreate" name="myform" v-form>

            <div class="form-group" v-validation-help>
                <label for="text" class="model_label">{{ trans('general.text') }}</label>
                <div class="model_input">
                    <input class="form-control"
                           name="text" id="text"
                           type="text"
                           v-model="ticker.text"
                           v-form-ctrl
                           required
                           minlength="3"
                           maxlength="50"
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
                    <button type="submit" @keydown.enter.prevent="attemptCreate" class="btn btn-primary">
                      <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                    </button>
                </div>
            </div>

        </form>

    </div>

</template>

<script type="text/ecmascript-6">
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {
        
        name: 'Create',

        directives: { ValidationHelp },

        data: function () {
            return {
                ticker: {
                    text: '',
                },
                myform: []
            }
        },

        methods: {

            attemptCreate() {

                if(this.myform.$valid)
                    this.createTicker();

            },

            createTicker() {

                var self = this;

                client({path: 'tickers', entity: self.ticker}).then(
                    
                    function (response, status) {

                        self.$dispatch('alert', {
                            message: self.trans('ticker.created'),
                            options: {theme: 'success'}
                        });

                        self.ticker.text = '';

                        if ( self.$root.history.previous == 'screengroups.show' )
                            self.$route.router.go( { path:'/tickers/'+response.entity.data.id, query: {screengroup: self.$root.history.params.id }});

                        else
                            self.$route.router.go('/tickers/'+response.entity.data.id);

                    },

                    function (response, status) {

                        self.$dispatch('alert', {
                            message: self.trans('ticker.created_fail'),
                            options: {theme: 'error'}
                        });

                    }

                );

            }

        }

    }
</script>
