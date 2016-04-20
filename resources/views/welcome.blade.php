<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="/js/main.js"></script>
    </head>
    <body>
    <div id="app">
        <h1>Hello App!</h1>
        <p>
            <a v-link="{ path: '/foo' }">Go to /foo</a>
            <a v-link="{ path: '/foo/bar' }">Go to /foo/bar</a>
            <a v-link="{ path: '/foo/baz' }">Go to /foo/baz</a>
        </p>
        <router-view></router-view>
    </div>
    </body>
</html>
