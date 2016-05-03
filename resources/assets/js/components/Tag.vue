<template id="tag-template">
    <legend>{{ trans('tag.model') }}
        <span class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" :style="error"
          title="{{ 'messages.atleast_one_tag' }}" :data-original-title="valid_info"></span>
    </legend>
    
    <div class="form-group">
        <div class="tag-group">
            <div class="tag label label-default" v-for="tag in list">
                <span class="tag__name">{{ tag.name }}</span>
                <a class="tag__remove btn btn-xs" @click="remove_tag($index),update_status">
                    <span class="fa fa-times"></span>
                </a>
            </div>
        </div>
        <div class="input-group">
            <input type="text" name="tags" id="inputTags" class="form-control" list="tags" v-model="new_tag" v-el="tagInput"
                   v-on:keyup.enter="add_tag" v-on:keyup="update_status">
            <datalist id="tags">
                <option v-for="tag in tags" value="{{ tag.name }}">{{ tag.name }}</option>
            </datalist>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" @click="add_tag">{{ trans('general.new') }}</button>
            </span>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['list', 'tags'],

        data: function() {
            return {
                new_tag: [],
            };
        },

        methods: {
            update_status: function(){
                if(this.isValid()){
                    $('#inputTags').parent().removeClass('has-warning');
                    $('#inputTags').parent().find('.btn').removeClass('disabled');
                }
                else{
                    $('#inputTags').parent().addClass('has-warning');
                    $('#inputTags').parent().find('.btn').addClass('disabled');
                }
            },
            add_tag: function(e) {
                // If there is a new tag, validate before adding
                if(this.new_tag && this.new_tag.length>0 && this.isValid()) {
                    var exists = false;
                    for (var i=0 ; i<this.tags.length ; i++)
                        if ( this.tags[i].name == this.new_tag.trim() )
                            exists = true;
                    if(exists) {
                        this.list.push({name: this.new_tag.trim()});
                        this.new_tag = '';
                        this.update_status();
                    }

                    else {
                        console.log("Need to add the tag, get the response and add it to tags and list")
                    }
                }
            },
            remove_tag: function(index) {
                this.list.splice(index, 1);
                this.update_status();
            },
            isValid: function() {
                // Check if input is in conflict with existing tag
                if (this.new_tag && this.new_tag.length>0)
                    for (var i=0 ; i<this.list.length ; i++)
                        if ( this.list[i].name == this.new_tag.trim() )
                            return false;
                return true;
            },
        },

        ready: function() {
            //update_tooltip();
        },

        computed: {
            error: function () {
                return (this.list.length < 1 || !this.isValid()) ? 'color:red' : '';
            },
            valid_info: function () {
                if (this.list.length < 1)
                    return this.trans('tag.tooltip_atleast_one_tag');
                if (!this.isValid())
                    return 'messages.tag_exists';
                return 'messages.atleast_one_tag';
            }
        },
    };
</script>