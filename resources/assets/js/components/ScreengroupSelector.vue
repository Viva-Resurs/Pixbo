<template>
    <legend>
        {{ trans_choice('screengroup.model', 1) }}
        <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_screengroup') }}"></span>
    </legend>
    <div class="form-group">
        <select class="form-control selectpicker show-tick" v-model="selected" id="inputModels" >
            <option v-for="model in models" v-bind:value="model.id">{{model.name}}</option>
        </select>
    </div>
</template>
<script type="text/ecmascript-6">
    export default {

        props: ['selected','model','options','mode'],

        data: function () {
            return {
                models: [] /*screengroups*/
            }
        },

        methods : {

            isMulti(){
                if (this.mode=="multi")
                    return true;
            },
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
            $(this.el).attr(this.mode); // TODO: FIX attr, < insert here ...... >
            if (this.model)
                this.getModels();
            if (this.options)
                this.models = this.options;
        },

    }
</script>