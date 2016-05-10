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
                        component: require('./pages/home/Welcome.vue')
                    },
                    '/about': {
                        component: require('./pages/home/About.vue')
                    }
                }
            },
            
            '/screengroups': {
                component: require('./pages/ScreenGroup.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        component: require('./pages/screengroups/index.vue')
                    },
                    '/:id': {
                        component: require('./pages/screengroups/show.vue')
                    },
                    '/create': {
                        component: require('./pages/screengroups/create.vue')
                    }
                }
            },
            '/screens': {
                component: require('./pages/Screen.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        component: require('./pages/screens/index.vue')
                    },
                    '/:id': {
                        component: require('./pages/screens/show.vue')
                    },
                    '/create': {
                        component: require('./pages/screens/create.vue')
                    }
                }
            },
            '/tickers': {
                component: require('./pages/Ticker.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        component: require('./pages/tickers/index.vue')
                    },
                    '/:id': {
                        component: require('./pages/tickers/show.vue'),

                        subRoutes: {
                            '/': {
                                component: require('./pages/tickers/basic.vue')
                            },
                            '/advanced': {
                                component: require('./pages/tickers/advanced.vue')
                            }
                        }
                    },
                    '/create': {
                        component: require('./pages/tickers/create.vue')
                    }
                }
            },
            '/terms': {
                component: require('./pages/Terms.vue')
            },
            '*': {
                component: require('./pages/404.vue')
            }
        })

        router.alias({
            '': '/home/welcome',
            '/': '/home/welcome',
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
