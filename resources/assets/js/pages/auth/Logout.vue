<script type="text/ecmascript-6">
    export default {

        route: {
            activate: function (transition) {
                this.$dispatch('userHasLoggedOut');
                transition.redirect('/');
            }
        }

    }
</script>