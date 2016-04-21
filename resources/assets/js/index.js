window.Vue = require('vue')
window.VueRouter = require('vue-router')
Vue.use(VueRouter)

var bootstrap = require('bootstrap-sass');

// Import the actual routes, aliases, ...
import { configRouter } from './routes'

// Create our router object and set options on it
const router = new VueRouter()

// Inject the routes into the VueRouter object
configRouter(router)

// Configure the application
window.config = require('./config')
Vue.config.debug = true

// Configure our HTTP client
var rest = require('rest')
var pathPrefix = require('rest/interceptor/pathPrefix')
var mime = require('rest/interceptor/mime')
var defaultRequest = require('rest/interceptor/defaultRequest')
var errorCode = require('rest/interceptor/errorCode')
var interceptor = require('rest/interceptor')
var jwtAuth = require('./interceptors/jwAuth.js')


window.client = rest.wrap(pathPrefix, { prefix: config.api.base_url })
    .wrap(mime)
    .wrap(defaultRequest, config.api.defaultRequest)
    .wrap(errorCode, { code: 400 })
    .wrap(jwtAuth);

// Bootstrap the app
Vue.component('nav-component', require('./components/Nav.vue'))
Vue.component('footer-component', require('./components/Footer.vue'))
const App = Vue.extend(require('./App.vue'))
router.start(App, '#app')
window.router = router