<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="/js/app.js"></script>
    <title>Document</title>
</head>
<body>

    <div id="app">
        <h1>Hello App!</h1>
        <p>
            <!-- use v-link directive for navigation. -->
            <a v-link="{ path: '/foo' }">Go to Foo</a>
            <a v-link="{ path: '/bar' }">Go to Bar</a>
        </p>
        <!-- route outlet -->
        <router-view></router-view>
    </div>

</body>
</html>