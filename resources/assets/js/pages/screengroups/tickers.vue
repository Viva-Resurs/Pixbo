/**
* Created by Christoffer Isenberg on 16-May-16.
*/

<template>
    <!-- TODO: Fix the styling of things-->
    <ticker-list :tickers="tickers"></ticker-list>
</template>

<script type="text/ecmascript-6">
    import TickerList from '../../components/TickerList.vue'
    export default {
        props: ['tickers'],
        components: { TickerList },

        methods: {
            // TODO remove association here
        },

        ready() {
            // Event listener for 'remove-ticker'
        }
    }
</script>