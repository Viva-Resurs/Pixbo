module.exports = {

    configRouter: function (router) {

        router.map({
            '/auth': {
                component: require('./pages/Auth.vue'),
                subRoutes: {
                    '/login': {
                        name: 'auth.login',
                        component: require('./pages/auth/Login.vue'),
                        guest: true
                    },
                    '/register': {
                        name: 'auth.register',
                        component: require('./pages/auth/Register.vue'),
                        guest: true
                    },
                    '/profile': {
                        name: 'auth.profile',
                        component: require('./pages/auth/Profile.vue'),
                        auth: true
                    },
                    '/logout': {
                        name: 'auth.logout',
                        component: require('./pages/auth/Logout.vue'),
                        auth: true
                    }
                }
            },
            '/home': {
                component: require('./pages/Home.vue'),
                subRoutes: {
                    '/': {
                        name: 'home.welcome',
                        component: require('./pages/home/Welcome.vue')
                    },
                    '/about': {
                        name: 'home.about',
                        component: require('./pages/home/About.vue')
                    }
                }
            },
            
            '/screengroups': {
                component: require('./pages/ScreenGroup.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        name: 'screengroups.index',
                        component: require('./pages/screengroups/index.vue')
                    },
                    '/:id': {
                        name: 'screengroups.show',
                        component: require('./pages/screengroups/show.vue')
                    },
                    '/create': {
                        name: 'screengroups.create',
                        component: require('./pages/screengroups/create.vue')
                    }
                }
            },
            '/screens': {
                component: require('./pages/Screen.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        name: 'screens.index',
                        component: require('./pages/screens/index.vue')
                    },
                    '/:id': {
                        name: 'screens.show',
                        component: require('./pages/screens/show.vue')
                    },
                    '/create': {
                        name: 'screens.create',
                        component: require('./pages/screens/create.vue')
                    }
                }
            },
            '/clients': {
                component: require('./pages/Client.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        name: 'clients.index',
                        component: require('./pages/clients/index.vue')
                    },
                    '/:id': {
                        name: 'clients.show',
                        component: require('./pages/clients/show.vue')
                    },
                    '/create': {
                        name: 'clients.create',
                        component: require('./pages/clients/create.vue')
                    }
                }
            },
            '/users': {
                component: require('./pages/User.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        name: 'users.index',
                        component: require('./pages/users/index.vue')
                    },
                    '/:id': {
                        name: 'users.show',
                        component: require('./pages/users/show.vue')
                    },
                    '/create': {
                        name: 'users.create',
                        component: require('./pages/users/create.vue')
                    }
                }
            },

            '/tickers': {
                component: require('./pages/Ticker.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        name: 'tickers.index',
                        component: require('./pages/tickers/index.vue')
                    },
                    '/:id': {
                        name: 'tickers.show',
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
                        name: 'tickers.create',
                        component: require('./pages/tickers/create.vue')
                    }
                }
            },
            '/categories': {
                component: require('./pages/Category.vue'),
                auth: true,
                subRoutes: {
                    '/': {
                        name: 'categories.index',
                        component: require('./pages/categories/index.vue')
                    },
                    '/:id': {
                        name: 'categories.show',
                        component: require('./pages/categories/show.vue')
                    },
                    '/create': {
                        name: 'categories.create',
                        component: require('./pages/categories/create.vue')
                    }
                }
            },
            '/terms': {
                name: 'terms',
                component: require('./pages/Terms.vue')
            },
            '*': {
                component: require('./pages/404.vue')
            }
        })

        router.alias({
            '': '/home/',
            '/': '/home/',
            '/auth': '/auth/login'
        })

        router.beforeEach(function (transition) {

            var token = localStorage.getItem('jwt-token')
            router.app.history.previous = transition.from.name
            router.app.history.params = transition.from.params

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
