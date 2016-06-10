/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <div class="panel-body" v-if=" screens.length == 0 ">
        {{ trans('screen.empty') }}
    </div>

    <div class="panel-body" v-if=" screens.length > 0 ">
        <div class="row">
            <div v-for="screen in screens">
                <screen-card :screen="screen" :index="$index" :from="from"></screen-card>
            </div>
            </ul>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    import ScreenCard from './ScreenCard.vue'
    export default {
        props: ['screens','from'],
        components: { ScreenCard }
    }
</script>