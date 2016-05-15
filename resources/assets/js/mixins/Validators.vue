<script type="text/ecmascript-6">
    export default {
        methods: {
            isIPAddress: val => /^(?!0)(?!.*\.$)((1?\d?\d|25[0-5]|2[0-4]\d)(\.|$)){4}$/.test(val)
        }
    }
</script>