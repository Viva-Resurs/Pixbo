module.exports = {

    configRouter: function (router) {

        router.map({
            '/auth': {
                component: require('./pages/Auth.vue'),
                subRoutes: {
                    '/login': {
                        component: require('./pages/auth/Login.vue'),
                        guest: true
                    },
                    '/register': {
                        component: require('./pages/auth/Register.vue'),
                        guest: true
                    },
                    '/profile': {
                        component: require('./pages/auth/Profile.vue'),
                        auth: true
                    },
                    '/logout': {
                        component: require('./pages/auth/Logout.vue'),
                        auth: true
                    }
                }
            },
            '/home': {
                component: require('./pages/Home.vue'),
                subRoutes: {
                    '/': {
                        component: require('./pages/home/Home.vue')
                    },
                    '/welcome': {
                        component: require('./pages/home/Welcome.vue')
                    },
                    '/about': {
                        component: require('./pages/home/About.vue')
                    }
                }
            },
            /*
            '/dogs': {
                component: require('./compiled/pages/dogs.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        component: require('./compiled/pages/dogs/index.vue')
                    },
                    '/:id': {
                        component: require('./compiled/pages/dogs/show.vue')
                    },
                    '/create': {
                        component: require('./compiled/pages/dogs/create.vue')
                    }
                }
            },*/
            '/terms': {
                component: require('./pages/Terms.vue')
            },
            '*': {
                component: require('./pages/404.vue')
            }
        })

        router.alias({
            '': '/home',
            '/auth': '/auth/login'
        })

        router.beforeEach(function (transition) {

            var token = localStorage.getItem('jwt-token')
            if (transition.to.auth) {
                if (!token || token === null) {
                    transition.redirect('/auth/login')
                }
            }
            if (transition.to.guest) {
                if (token) {
                    transition.redirect('/')
                }
            }
            transition.next()
        })
    }
}
