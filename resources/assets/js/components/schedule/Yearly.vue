<template>
    <div class="form-group">
        <div class="form-group">
            <label for="inputFrequency" class="control-label">{{ trans('schedule.frequency') }}</label>
            <input v-model="event.frequency" type="number" name="frequency" id="inputFrequency" class="form-control" v-bind:value="event.frequency" min='1' max='365' step='1' required="required" title="">
        </div>
    </div>
</template>
<script>
    export default {
        props: ['event'],
        data() {
            return {

            }
        }
    }
</script>