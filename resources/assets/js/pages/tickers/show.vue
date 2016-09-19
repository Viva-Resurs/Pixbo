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
                               maxlength="200"
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

        route: {
            data: function (transition) {
                client({ path: '/tickers/' + this.$route.params.id }).then(
                    function (response) {
                        transition.next({ticker: response.entity.data});
                    },
                    function (response){
                        transition.next();
                        console.error(response.entity.error);
                    }
                );
            }
        }

    }
</script>
