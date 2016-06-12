/**
* Created by Christoffer Isenberg on 23-May-16.
*/

<script type="text/ecmascript-6">

    import { store } from '../store'
    export default {

        data() {
            return {
                store: store
            }
        },

        methods: {
            setLogin(user) {
                store.user = user;
                store.authenticated = true;
                store.token = localStorage.getItem('jwt-token')
            },
            destroyLogin(user) {
                store.user = null;
                store.token = null;
                store.authenticated = false;
                localStorage.removeItem('jwt-token');
                this.$route.router.go('/auth/login')
            },
            getUser() {
                var token = localStorage.getItem('jwt-token')

                if (token !== null && token !== 'undefined') {
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
            },
        },

        computed: {
            isAdmin() {
                if(this.store.user)
                    return this.store.user.isAdmin;
                else return false
            },

            username() {
                if(this.store.user)
                    return this.store.user.name
                else return null
            },
            isAuthenticated() {
                return this.store.authenticated
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

            this.$on('userHasFetchedToken', function(token) {
                this.store.token = token;
            })

            this.getUser();
        }
    }
</script>
