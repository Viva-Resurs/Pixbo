/**
* Created by Christoffer Isenberg on 23-May-16.
*/

<script type="text/ecmascript-6">
    // helper to set first character to be capitalized in a given string.
    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }

    export default {

        computed: {
            isAdmin() {
                return this.$root.user.isAdmin;
            },
            isAuthenticated() {
                return this.$root.authenticated
            },
            username() {
                return (this.$root.user.name).capitalize()
            }
        }
    }
</script>
