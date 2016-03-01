
<template id="tag-template">
    <legend>
        asdf
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="asdfasdf"></span>
    </legend>
    <div class="form-group">
        <div class="tag-group">
            <div class="tag" v-for="tag in tag_list">{{ tag.name }}</div>
        </div>

        <div class="input-group">
            <input type="text" name="tags" id="inputTags" class="form-control" list="tags">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
            <datalist id="tags">
                <option v-for="tag in tags" value="{{ tag.name }}">{{ tag.name }}</option>
            </datalist>
        </div>
    </div>
</template>

<script>
    export default {

        data: function() {
            return {
                tags: [],
                tag_list: [],
            };
        },

        methods: {
            update_tags: function() {

            },
            send_post: function() {

                var day_num = null;
                var recur = this.event.recur_type;

                switch(recur) {
                    case "weekly":
                        day_num = this.weekly_day_num;
                        break;
                    case "monthly":
                        day_num = this.monthly_day_num;
                        break;
                    default:
                        day_num = '';
                        break;
                }
                var payload = {
                    selected_tags: this.selected_tags,
                    modelObject: this.modelObject,
                };
                this.send_ajax(payload);

            },

            send_ajax: function(payload) {
                var vm = this;
                console.log(vm.modelObject);
                this.$http.put('/admin/' + vm.model + 's/' + vm.modelObject.id, payload).then(function (response) {
                    if(response.ok) {
                        vm.close_modal();
                    }
                    if(response) {
                        vm.$dispatch('add-alert', response.data);
                    }

                });
            },

            get_all_tags: function() {
                this.$http.get('/api/tags', function(tags) {
                    this.tags = tags;
                }.bind(this));
            },
            get_model: function() {

                this.$http.get('/api/screen/' + this.$parent.$data.id, function(modelObject) {
                    this.tag_list = modelObject.tags;

                }.bind(this));
            },
        },


        ready: function () {
        this.get_all_tags();
        this.get_model();
        },
    };
</script>

<style>

</style>