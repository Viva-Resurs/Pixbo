<form id="screenform" action="" method="POST" role="form" v-on:submit.prevent="send_post">
    {{ csrf_field () }}


    @include('shared.schedule_new_template')


    <button type="submit" class="btn btn-primary">{{ trans('messages.save') }}</button>
</form>