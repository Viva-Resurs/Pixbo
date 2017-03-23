<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                store: {
                    user: {
                        id: null,
                        name: null,
                        email: null,
                        roles: []
                    },
                    token: null,
                    authenticated: null
                }
            }
        },
        methods: {
            setLogin(user) {
                this.store.user = user;
                this.store.authenticated = true;
                this.store.token = localStorage.getItem('jwt-token');

                if (this.$root.loginCheck)
                    clearInterval(this.$root.loginCheck);
                this.$root.loginCheck = false;
                this.$root.loginCheck = setInterval( this.getUser, 1000*30 );
            },

            destroyLogin(user) {
                this.store.user = null;
                this.store.token = null;
                this.store.authenticated = false;
                localStorage.removeItem('jwt-token');

                if (this.$root.loginCheck)
                    clearInterval(this.$root.loginCheck);
                this.$root.loginCheck = false;

                if (this.$route.auth)
                    this.$route.router.go('/auth/login');
            },

            getUser() {
                var token = localStorage.getItem('jwt-token');

                if (token !== null && token !== 'undefined') {
                    var self = this;

                    client({path: '/users/me'}).then(
                        function (response) {
                            // Verify that user-data returned is OK
                            if (!response.entity.data)
                                self.destroyLogin();

                            // User has successfully logged in using the token from storage
                            self.setLogin(response.entity.data);

                            // Broadcast an event telling our children that the data is ready and views can be rendered
                            self.$broadcast('data-loaded');
                        },
                        function (response) {
                            // Login with our token failed, do some cleanup and redirect if we're on an authenticated route
                            self.destroyLogin();
                        }
                    );
                }
                else
                    this.destroyLogin();
            },

            isOwner(model) {
                if (this.isAdmin)
                    return true;
                return model.user_id == this.store.user.id;
            }
        },

        computed: {
            isAdmin() {
                if(this.store.user)
                    return this.store.user.isAdmin;
                else
                    return false;
            },
            username() {
                if(this.store.user)
                    return this.store.user.name;
                else
                    return null;
            },
            isAuthenticated() {
                return this.store.authenticated;
            }
        },

        created: function() {
            this.$on('userHasLoggedOut', function () {
                this.destroyLogin();
            });
            this.$on('userHasLoggedIn', function (user) {
                this.setLogin(user);
            });
            this.$on('userHasFetchedToken', function(token) {
                this.store.token = token;
            });
            this.$on('userHasUpdatedProfile', function () {
                this.getUser();
            });
            this.getUser();
        }
    }
</script>
