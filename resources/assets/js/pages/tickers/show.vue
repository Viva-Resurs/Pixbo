<template>

    <div class="panel-heading">
        {{ trans('ticker.edit') }}
    </div>

    <div class="panel-body" v-if="$loadingRouteData">
        <loading></loading>
    </div>

    <div v-else>

        <schedule :model.sync="ticker">
            <div slot="model_specific_setting">
                <div class="form-group" v-validation-help>
                    <label for="ticker_text" class="model_label">{{ trans('general.text') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="ticker_text" id="inputTickerText"
                               type="text"
                               v-model="ticker.text"
                               v-form-ctrl
                               required
                               minlength="3"
                               maxlength="50"
                        >
                    </div>
                </div>
                <hr>
            </div>
        </schedule>

    </div>

</template>

<script type="text/ecmascript-6">
    import Schedule from '../../components/Schedule.vue'
    import ValidationHelp from '../../directives/ValidationHelp.vue'

    export default {

        name: 'Show',

        components: { Schedule },

        directives: { ValidationHelp },

        data: function () {
            return {
                ticker: {}
            }
        },

        methods: {

            fetch(id) {

                var self = this;

                client({ path: '/tickers/' + id }).then(

                    function (response) {

                        self.$set('ticker', response.entity.data);
                        
                        if ( self.$route.query.screengroup )
                            self.ticker.screengroups.push( { id: self.$route.query.screengroup });

                    },

                    function (response) {

                        if (response.entity && response.entity.error)
                            console.error(response.entity.error.message);

                        if (!self.attempts || self.attempts < 3)

                            setTimeout(function(){

                                self.attempts = (self.attempts) ? self.attempts+1 : 1;
                                self.fetch(id);

                            },1000);

                    }

                );

            }

        },

        created: function(){
            this.fetch(this.$route.params.id);
        }

    }
</script>
