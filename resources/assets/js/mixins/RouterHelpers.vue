/**
* Created by Christoffer Isenberg on 16-May-16.
*/


<script type="text/ecmascript-6">
    export default {
        methods: {
            goBack() {
                if(this.$root.history.params) {
                    router.go({ name: this.$root.history.previous, params: this.$root.history.params})
                } else {
                    router.go({ name: this.$root.history.previous})
                }
            }
        }
    }
</script>