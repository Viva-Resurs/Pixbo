<legend>
    {{ trans_choice('messages.tag',2) }}
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.tag_tooltip') }}"></span>
</legend>
<div class="form-group">
    <div class="">
        <input type="text" v-model="selected_tags" v-bind:value="tagged" name="tags" id="inputTags" class="form-control" required="required" placeholder="tag tag">
    </div>
</div>