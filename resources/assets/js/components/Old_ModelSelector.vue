<template>
    <div class="form-group">
        <label for="model" class="col-sm-2 col-sm-offset-1 control-label">{{ trans_choice(model + '.model', 1) }}</label>
        <div class="col-sm-5">
            <select name="model" id="model" class="form-control" v-model="selected">
                <option :value="null">{{ trans(model + '.select') }}</option>
                <option v-for="element in models" v-bind:value="element.id">{{ element.name }}</option>
            </select>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    export default {
        props: ['selected', 'model'],

        data() {
            return {
                models: null
            }
        },

        methods: {
            getModels() {
                var self = this;
                client({ path: `/${self.model}s` }).then(
                        function (response) {
                            self.$set('models', response.entity.data);
                        },
                        function (response, status) {
                            if (_.contains([401, 500], status)) {
                                self.$dispatch('userHasLoggedOut');
                            }
                        }
                )
            }
        },
        created() {
            this.getModels();
        }
    }
</script>