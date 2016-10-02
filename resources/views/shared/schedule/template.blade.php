<template id="schedule-template">
    <form id="schedule_form_{{ $model }}_{{ $item->id }}" action="/admin/{{ $model }}/{{ $item->id }}" method="PATCH" role="form" v-on:submit.prevent="send_post">
        {{ csrf_field() }}

        <template v-if="model == 'tickers'">
            @include('tickers.modal.head')
        </template>

        <div class="col-lg-6 col-md-6">
        
            @include('shared.schedule.screengroup')

            <template v-if="model == 'screens'">
                @include('shared.schedule.tags')
            </template>


            @include('shared.schedule.datetime')

        </div>

        <div class="col-lg-6 col-md-6">

            @include('shared.schedule.recurring.body')

        </div>

        <button type="submit" id="submitButton_@{{ id }}" class="" style="display: none;">{{ trans('messages.save') }}</button>

     </form>
</template>