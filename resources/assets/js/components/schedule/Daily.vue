<template>

    <div class="column">

        <frequency :frequency.sync="event.frequency" type="day"></frequency>

    </div>

</template>

<script type="text/ecmascript-6">
    import Frequency from './Frequency.vue'

    export default {

    	name: 'Daily',

        props: [ 'event' ],

        components: { Frequency }

    }
</script>
