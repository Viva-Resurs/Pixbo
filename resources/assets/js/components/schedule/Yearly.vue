<template>

	<div class="column">
    	
    	<frequency :frequency.sync="event.frequency" type="year"></frequency>
    
    </div>

</template>

<script type="text/ecmascript-6">
    import Frequency from './Frequency.vue'

    export default {

    	name: 'Yearly',

        props: [ 'event' ],

        components: { Frequency }

    }
</script>
