<template>
    <div>
        <nav-component></nav-component>
        <toaster></toaster>
        <router-view></router-view>
        <footer-component></footer-component>
    </div>
</template>

<script>
    import Toaster from './components/Toaster.vue'

    export default {

        components: {
          Toaster
        },

        data() {
            return {
                user: null,
                token: null,
                authenticated: false,
                history: {
                    previous: null,
                    params: null
                }
            }
        },

        // Auth stuff
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
                localStorage.removeItem('jwt-token');
                if(this.$route.auth) this.$route.router.go('/auth/login')
            },
            getUser() {
                var token = localStorage.getItem('jwt-token')

                if (token !== null && token !== 'undefined') {
                    console.log("fetching user")
                    var that = this
                    client({path: '/users/me'}).then(
                            function (response) {
                                // User has successfully logged in using the token from storage
                                that.setLogin(response.entity.data)
                                // broadcast an event telling our children that the data is ready and views can be rendered
                                that.$broadcast('data-loaded')
                            },
                            function (response) {
                                // Login with our token failed, do some cleanup and redirect if we're on an authenticated route
                                that.destroyLogin()
                            }
                    )
                }
            }
        },

        created() {

            this.$on('alert', function (args) {
                this.$broadcast('alert', args);
            })

            this.$on('userHasLoggedOut', function () {
                this.destroyLogin()
            })

            this.$on('userHasLoggedIn', function (user) {
                console.log('user has logged in')
                this.setLogin(user)
            })

            this.getUser();
        }
    }
</script>