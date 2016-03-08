
<template id="tag-template">
    <legend>
        Taggar
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="asdfasdf"></span>
    </legend>
    <div class="form-group">
        <div class="tag-group">
            <ul>
                <li class="tag" v-for="tag in list">
                    <span class="tag__name">{{ tag.name }}</span>
                    <button class="tag__remove" @click="remove_tag($index)">X</button>
            </ul>

        </div>

        <div class="input-group">
            <input type="text" name="tags" id="inputTags" class="form-control" list="tags" v-model="new_tag" v-el="tagInput" v-on:keyup.enter="add_tag">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" @click="add_tag">Lägg till</button>
            </span>
            <datalist id="tags">
                <option v-for="tag in tags" value="{{ tag.name }}">{{ tag.name }}</option>
            </datalist>
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
            update_tags: function() {

            },


            add_tag: function(that) {
                console.log(this.new_tag);
                if(this.new_tag.length > 0) {

                    this.list.push({name: this.new_tag.trim(), new: true});
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
            }
        },
    };
</script>

<style>

</style>