<template>
    <div>
        <frequency :frequency.sync="event.frequency" type="day"></frequency>
    </div>
</template>
<script>
    import Frequency from './Frequency.vue'

    export default {
        props: ['event'],
        components: { Frequency },
    }
</script>