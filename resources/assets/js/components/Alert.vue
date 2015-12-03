<template>
    <div v-bind:class="alertClasses" v-show="show">
        <slot></slot>
        <span class="Alert__close" @click="show = false">x</span>
    </div>
</template>

<script>
    export default {

        props: ['type'],

        data: function() {
            return {
                show: true
            };
        },

        computed: {
            alertClasses: function () {
                var type = this.type;
                return {
                    'Alert': true,
                    'Alert--Success': type == 'success',
                    'Alert--Error': type == 'error'
                };
            }
        }
    };
</script>