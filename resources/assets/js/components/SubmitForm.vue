<template>
    <label :for="target" class="btn btn-primary">{{ 'messages.save' }}</label>
</template>

<script>
    export default {
        props: ['target'],
    }
</script>