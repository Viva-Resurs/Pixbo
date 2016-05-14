/**
* Created by Christoffer Isenberg on 14-May-16.
*/

<template>
    <vue-toast v-ref:toast></vue-toast>
</template>

<script type="text/ecmascript-6">
    import vueToast from 'vue-toast'

    export default {
        data() {
            return {
                maxToasts: 6,
                position: 'top right', // possible '[left, right] [top, bottom]
                theme: 'error', // info warning error success
                timeLife: 3000,
                closeBtn: true
            }
        },
        components: {
            vueToast
        },
        attached() {
            this.resetOptions()
        },
        watch: {
            'maxToasts + position': 'resetOptions'
        },
        methods: {
            resetOptions() {
                this.$refs.toast.setOptions({
                    maxToasts: this.maxToasts,
                    position: this.position
                })
            },
            showTime(message, options) {
                this.$refs.toast.showToast(message, {
                    theme: typeof options.theme !== 'undefined' ? options.theme : this.theme,
                    timeLife: typeof options.timeLife !== 'undefined' ? options.timeLife : this.timeLife,
                    closeBtn: typeof options.closeBtn !== 'undefined' ? options.closeBtn : this.closeBtn
                })
            }
        },
        ready() {
            this.$on('alert', function (block) {
                if(typeof block.options === 'undefined') {
                    block.options = {}
                }
                this.showTime(block.message, block.options)
            })
        }
    }
</script>