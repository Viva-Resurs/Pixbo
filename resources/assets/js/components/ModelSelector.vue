<template>
    <legend>
        <slot name="label">

        </slot>
    </legend>
    <div class="form-group">
        <select class="form-control selectpicker show-tick"
                v-model="selected"
                id="inputModels"
                :multiple="multiple"
                :data-selected-text-format="mode"
        >
            <option v-for="model in models" v-bind:value="model.id">{{trans(model.name)}}</option>
        </select>
    </div>
</template>
<script type="text/ecmascript-6">
    export default {

        props: {
            selected: [Number, Object],
            model: {
                type: String
            },
            options: Array,
            mode: {
                type: String,
                default: ''
            },
            multiple: {
                type: String,
                default: false
            },
            title: String
        },

        data: function () {
            return {
                models: [] /*screengroups*/
            }
        },

        computed: {
            getTitle() {
                if(this.model) {
                    console.log(`${this.model}.model`)
                    return `${this.model}.model`
                } else {
                    return this.title
                }
            }
        },

        methods : {
            getModels() {
                var self = this;
                client({ path: `/${self.model}s` }).then(
                    function (response) {
                        self.$set('models', response.entity.data);
                        self.$nextTick(function() {
                            $('.selectpicker').selectpicker({
                              size: 4,
                              iconBase: 'fa',
                              tickIcon: 'fa-check',
                              noneSelectedText: self.trans('general.nothing_selected'),
                            });
                        });
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            self.$dispatch('userHasLoggedOut');
                        }
                    }
                );
            },

        },

        created: function(){
            if (this.model)
                this.getModels();
            if (this.options)
                this.models = this.options;
        },

    }
</script>