<template>
    <div class="form-group">
        <label for="screengroup" class="col-sm-2 col-sm-offset-1 control-label">{{ trans_choice('screengroup.model', 1) }}</label>
        <div class="col-sm-5">
            <select name="screengroup" id="screengroup" class="form-control" v-model="selected">
                <option :value="null">{{ trans('screengroup.select') }}</option>
                <option v-for="screengroup in screengroups" v-bind:value="screengroup.id">{{ screengroup.name }}</option>
            </select>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    export default {
        props: ['selected'],

        data() {
            return {
                screengroups: null
            }
        },

        methods: {
            getScreengroups() {
                var self = this;
                client({ path: '/screengroups' }).then(
                        function (response) {
                            self.$set('screengroups', response.entity.data);
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
            this.getScreengroups();
        }
    }
</script>