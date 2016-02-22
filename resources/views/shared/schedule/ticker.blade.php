<legend>{{ trans_choice('messages.ticker',1) }}</legend>
<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Text:</label>
    <div class="col-sm-10">
        <input v-model="modelObject.text" type="text" name="text" id="inputText" class="form-control" required="required" title="">
    </div>
</div>