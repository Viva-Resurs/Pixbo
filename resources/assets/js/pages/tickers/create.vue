<template>

    <div class="panel-heading">
        {{ trans('ticker.create') }}
    </div>

    <div class="panel-body">

        <form class="form-horizontal" role="form" v-on:submit.prevent="createTicker">

            <div class="form-group">
                <label for="text" class="model_label">{{ trans('general.text') }}</label>
                <div class="model_input">
                    <input class="form-control" required="required" name="text" type="text" v-model="ticker.text" id="nameInput">
                </div>
            </div>

            <div class="form-group">
                <div class="model_action">
                    <button type="button" class="btn" @click="goBack" v-if="emptyfields">
                      <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                    </button>
                    <button type="button" class="btn" @click="goBack" v-if="!emptyfields">
                      <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                    </button>
                    <button type="submit" @keydown.enter.prevent="createTicker" class="btn btn-primary" :disabled="emptyfields">
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
                ticker: {
                    text: '',
                }
            }
        },

        computed: {
             emptyfields: function(){
                return (this.ticker.text=='') ? true : false;
             },
            isValid() {
                // TODO: Add validation
            }
        },

        methods: {
            createTicker: function () {
                var self = this;
                client({path: 'tickers', entity: self.ticker}).then(
                    function (response, status) {
                        self.ticker.text = '';
                        self.$dispatch('alert', {
                            message: self.trans('ticker.created'),
                            options: {theme: 'success'}
                        })
                        if ( self.$root.history.previous == 'screengroups.show' )
                            self.$route.router.go( { path:'/tickers/'+response.entity.data.id, query: {screengroup: self.$root.history.params.id }});
                        else
                            self.$route.router.go('/tickers/'+response.entity.data.id);
                    },
                    function (response, status) {
                        self.$dispatch('alert', {
                            message: self.trans('ticker.created_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }
        }
    }
</script>

