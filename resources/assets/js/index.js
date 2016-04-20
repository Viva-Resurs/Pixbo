window.Vue = require('vue')
window.VueRouter = require('vue-router')
Vue.use(VueRouter)

Vue.use(require('vue-resource'))

var router = new VueRouter()

import App from './components/App.vue'
import Home from './components/Home.vue'
import Login from './components/auth/Login.vue'


router.map({
    '/home': {
        component: Home
    },
     //    'secretquote': {
     //    component: SecretQuote
     //    },
         '/login': {
         component: Login
         },
     //    '/signup': {
     //    component: Signup
     //    } */


})

router.redirect({
    '*': '/home'
})



router.start(App, '#app')