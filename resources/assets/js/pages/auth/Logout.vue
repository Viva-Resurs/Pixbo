<script>
    module.exports = {

        route: {
            activate: function (transition) {
                this.$dispatch('userHasLoggedOut')
                transition.redirect('/')
            }
        }

    }
</script>