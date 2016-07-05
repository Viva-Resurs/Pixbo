<script type="text/ecmascript-6">
    export default {

        methods: {

            isIPAddress: val => /^(?!0)(?!.*\.$)((1?\d?\d|25[0-5]|2[0-4]\d)(\.|$)){4}$/.test(val),
            
            isMacAddress: val => /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/.test(val)

        }

    }
</script>
