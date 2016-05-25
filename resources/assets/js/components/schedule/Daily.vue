<template>
    <frequency :frequency.sync="frequency"></frequency>
</template>
<script>
    import Frequency from './Frequency.vue'

    export default {
        props: ['frequency'],
        components: { Frequency },
    }
</script>