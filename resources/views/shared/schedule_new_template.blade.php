<template id="schedule-template">

    <div class="col-lg-6">

        @include('shared.schedule.screengroup')

        <template v-if="model == 'screen'">
            @include('shared.schedule.tags')
        </template>

        <legend>{{ trans('messages.schedule') }}</legend>
        <div class="col-md-12">

            @include('shared.schedule.datetime')
            @include('shared.schedule.recurring.body')


        </div>


</template>
