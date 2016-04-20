window.Vue = require('vue');
window.VueRouter = require('vue-router');
Vue.use(VueRouter);

Vue.use(require('vue-resource'));

var router = new VueRouter({
    history: true,
    root: 'app'
});

// Define some components
var Foo = Vue.extend({
    template:
    '<div class="foo">' +
    '<h2>This is Foo!</h2>' +
    '<router-view></router-view>' + // <- nested outlet
    '</div>'
})

var Bar = Vue.extend({
    template: '<p>This is bar!</p>'
})

var Baz = Vue.extend({
    template: '<p>This is baz!</p>'
})

// The router needs a root component to render.
// For demo purposes, we will just use an empty one
// because we are using the HTML as the app template.
// !! Note that the App is not a Vue instance.
var App = Vue.extend({})

// Create a router instance.
// You can pass in additional options here, but let's
// keep it simple for now.
var router = new VueRouter()

// Define some routes.
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
/*
router.map({
    '/foo': {
        component: Foo,
        // add a subRoutes map under /foo
        subRoutes: {
            '/': {
              component: {
                  template: '<p>Default sub view for Foo</p>'
              }
            },
            '/bar': {
                // Bar will be rendered inside Foo's <router-view>
                // when /foo/bar is matched
                component: Bar
            },
            '/baz': {
                // Same for Baz, but only when /foo/baz is matched
                component: Baz
            }
        }
    },
    '/bar': {
        component: Bar
    }
})
*/
router.map({
    '/foo': {
        component: Foo,
        // add a subRoutes map under /foo
        subRoutes: {
            '/': {
                // This component will be rendered into Foo's <router-view>
                // when /foo is matched. Using an inline component definition
                // here for convenience.
                component: {
                    template: '<p>Default sub view for Foo</p>'
                }
            },
            '/bar': {
                // Bar will be rendered inside Foo's <router-view>
                // when /foo/bar is matched
                component: Bar
            },
            '/baz': {
                // same for Baz, but only when /foo/baz is matched
                component: Baz
            }
        }
    }
})

// Now we can start the app!
// The router will create an instance of App and mount to
// the element matching the selector #app.
router.start(App, '#app')