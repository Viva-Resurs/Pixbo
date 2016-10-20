<legend>
    {{ trans_choice('messages.screen_group',2) }}
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.screengroup_tooltip') }}"></span>
</legend>
<select class="form-control" multiple v-model="selected_screengroups" id="inputScreengroups">
    <option v-for="screengroup in screengroups" v-bind:value="screengroup.value">@{{screengroup.text}}</option>
</select>