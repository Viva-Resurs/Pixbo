<template>
    <slot name="label">

    </slot>

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
            options: {
                type: Array,
                default: val => []
            },
            mode: {
                type: String,
                default: ''
            },
            multiple: {
                type: String,
                default: false
            }
        },

        data: function () {
            return {
                models: [] /*screengroups*/
            }
        },

        methods : {
            getModels() {
                var self = this;
                client({ path: `/${self.model}s` }).then(
                    function (response) {
                        self.$set('models', response.entity.data);
                        self.setSelectPicker();
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            self.$dispatch('userHasLoggedOut');
                        }
                    }
                );
            },

            setSelectPicker() {
                this.$nextTick(function() {
                    $(this.$el.nextElementSibling.children.inputModels).selectpicker({
                        size: 4,
                        iconBase: 'fa',
                        tickIcon: 'fa-check',
                        noneSelectedText: this.trans('general.nothing_selected'),
                    });
                });
            }
        },


        created: function(){
            if (this.model)
                this.getModels();
            if (this.options.length > 0) {
                this.models = this.options;
            }
        },
        ready() {
            if (this.options.length > 0) {
                this.setSelectPicker();
            }
        }
    }
</script>