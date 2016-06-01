/**
* Created by Christoffer Isenberg on 16-May-16.
*/


<script type="text/ecmascript-6">
    export default {
        methods: {
            // TODO: Might want to check if history is empty and if that's the case use a parameter to
            // get an option where to go. Right now it will resend posts and everything if page is refreshed
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