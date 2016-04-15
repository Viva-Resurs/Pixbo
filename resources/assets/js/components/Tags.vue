<template id="tag-template">
    <legend>
        Taggar
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.atleast_one_tag') }}" :style="error"></span>
    </legend>
    <div class="form-group">
        <div class="tag-group">
            <div class="tag label label-default" v-for="tag in list">
                <span class="tag__name">{{ tag.name }}</span>
                <a class="tag__remove btn  btn-xs" @click="remove_tag($index)">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
        </div>
        <div class="input-group">
            <input type="text" name="tags" id="inputTags" class="form-control" list="tags" v-model="new_tag" v-el="tagInput" v-on:keyup.enter="add_tag">
            <datalist id="tags">
                <option v-for="tag in tags" value="{{ tag.name }}">{{ tag.name }}</option>
            </datalist>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" @click="add_tag">Lägg till</button>
            </span>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['list'],

        data: function() {
            return {
                new_tag: [],
            };
        },

        methods: {
            add_tag: function(that) {
                if(this.new_tag.length > 0) {
                    var exists = !(this.list.indexOf(this.new_tag.trim()) > -1);
                    if (!exists) {
                        this.list.push({name: this.new_tag.trim(), new: true});
                    }


                }
                this.new_tag = '';
            },
            remove_tag: function(index) {
                this.list.splice(index, 1);
            },
        },

        ready: function() {
            this.list = this.list;
        },

        computed: {
            tags: function() {
                return this.$parent.$data.tags;
            },
            error: function () {
                return this.list.length > 0 ? '' : 'color:red';
            }
        },
    };
</script>

<style>

</style>