<template>

	<div class="column">
    	
    	<frequency :frequency.sync="event.frequency" type="year"></frequency>
    
    </div>

</template>
<script>
    import Frequency from './Frequency.vue'
    export default {
        props: ['event'],
        components: { Frequency }
    }
</script>