<template>
    <slot name="label">

    </slot>

    <div :class="classes">
        <!-- TODO: 'Fix Mån Tis Ons' in model-selector mode/dropdown title -->
        <select class="form-control selectpicker show-tick"
                v-model="selected"
                id="inputModels"
                :multiple="multiple"
                :data-selected-text-format="mode"
                formated="formated"
                v-el:select-input
        >
            <option v-for="element in models" :value="element.id">{{element.name}}</option>
            <option v-for="option in options" :value="option.id">
                <template v-if="formated=='yes'">
                    {{option.name}}
                </template>
                <template v-else>
                    <template v-if="hasType"> {{trans(option.name) + " " + trans('schedule.'+this.type,option.id).toLowerCase()}} </template>
                    <template v-else> {{trans(option.name)}} </template>
                </template>
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
            formated: {
                type: String,
                default: ''
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
                    // TODO: More Lang-fixes...
                    var target = $(this.$els.selectInput);
                    target.selectpicker({
                        size: 4,
                        iconBase: 'fa',
                        tickIcon: 'fa-check',
                        multipleSeparator: ' ',
                        countSelectedText: function(){
                            var text = '';
                            for (var i=0; i<target[0].selectedOptions.length ; i++)
                                 text += target[0].selectedOptions[i].label.substring(0,3) + ' ';
                            console.log(text);
                            return text;
                        },
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