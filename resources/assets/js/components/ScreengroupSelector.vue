<template>
    <legend>
        {{ trans_choice('screengroup.model', 1) }}
        <span class="fa fa-question-circle" v-tooltip data-original-title="{{ trans('schedule.tooltip_screengroup') }}"></span>
    </legend>
    <div class="form-group">
        <select class="form-control selectpicker show-tick" multiple v-model="selected" id="inputScreengroups" data-selected-text-format="count > 3">
            <option v-for="screengroup in screengroups" v-bind:value="screengroup.id">{{screengroup.name}}</option>
        </select>
    </div>
</template>
<script>
    export default {

        props: ['selected'],

        data: function () {
            return {
                screengroups: []
            }
        },

        methods : {

            fetchScreengroups: function () {
                var that = this;
                client({ path: '/screengroups' }).then(
                    function (response) {
                        that.$set('screengroups', response.entity.data);
                        that.$nextTick(function() {
                            $('.selectpicker').selectpicker({
                              size: 4,
                              iconBase: 'fa',
                              tickIcon: 'fa-check',
                              noneSelectedText: that.trans('general.nothing_selected'),
                            });
                        });
                    },
                    function (response, status) {
                        if (_.contains([401, 500], status)) {
                            that.$dispatch('userHasLoggedOut');
                        }
                    }
                );
            }

        },

        created: function(){
            this.fetchScreengroups();
        },

    }
</script>