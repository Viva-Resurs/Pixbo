<template>
    <slot name="label">

    </slot>

    <div :class="classes">
        <select class="form-control selectpicker show-tick"
                v-model="selected"
                id="inputModels"
                :multiple="multiple"
                :data-selected-text-format="mode"
                v-el:select-input
        >
            <option v-for="element in models" :value="element.id">{{element.name}}</option>
            <option v-for="option in options" :value="option.id">
                <template v-if="hasType"> {{trans(option.name) + " " + trans('schedule.'+this.type,1).toLowerCase()}} </template>
                <template v-else> {{trans(option.name)}} </template>
            </option>
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
            },
            type: {
                type: String,
                default: ''
            },
            classes: {
                type: String,
                default: 'form-group'
            }
        },

        data: function () {
            return {
                models: [] /*screengroups*/
            }
        },

        computed: {
            hasType(){
                return (this.type!=='')
            },
            isModel() {
                return (this.model!=='')
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
                    $(this.$els.selectInput).selectpicker({
                        size: 4,
                        iconBase: 'fa',
                        tickIcon: 'fa-check',
                        noneSelectedText: this.trans('general.nothing_selected'),
                    });
                });
            }
        },

        created(){
            if (this.model)
                this.getModels();
            if (this.options.length > 0)
                this.setSelectPicker();
        },
    }
</script>