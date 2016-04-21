<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {

        // Auth stuff
        ready() {
            this.$on('userHasLoggedOut', function () {
                this.destroyLogin()
            })

            this.$on('userHasLoggedIn', function (user) {
                console.log('user has logged in')
                this.setLogin(user)
            })

            var token = localStorage.getItem('jwt-token')
            if(token != null && token != 'undefined') {
                // get 'myself' from server, login

            }
        },

        data() {
            return {
                user: null,
                token: null,
                authenticated: false
            }
        },
        methods: {
            setLogin(user) {
                this.user = user;
                this.authenticated = true;
                this.token = localStorage.getItem('jwt-token')
            },
            destroyLogin(user) {
                this.user = null;
                this.token = null;
                this.authenticated = false;
                localStorage.removeItem('jwt-token')
                if(this.$route.auth) this.$route.router.go('/auth/login')
            }
        }
    }
</script>