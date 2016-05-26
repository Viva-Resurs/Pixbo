<template>
    <frequency :frequency.sync="frequency" type="day"></frequency>
</template>
<script>
    import Frequency from './Frequency.vue'

    export default {
        props: [
            'frequency',
            'monthly_day_num',
            'day_num',
            'days_before_event',
            'recur_day'
        ],
        components: { Frequency },
    }
</script>