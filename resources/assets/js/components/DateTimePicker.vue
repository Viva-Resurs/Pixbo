<template>
    <div class="input-append date" id="dp3" data-date="12-02-2015" data-datepicker-format="dd-mm-yyyy">
        <input class="col-md-2" size="16" type="text" value="12-02-2015">
        <span class="input-group-addon"><i class=".glyphicon .glyphicon-th"></i></span>
    </div>
</template>
<script>
    import moment from 'Moment'

    export default {
        props: ['time', 'date'],

        data() {
            return {

            }
        },
        methods: {

        },
        ready() {
        }
    }
</script>