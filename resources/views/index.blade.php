<!DOCTYPE html>
<html>
    <head>
        <title>Pixbo::Admin</title>
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>

        <script src="/js/vendor.js"></script>
        <script src="/js/index.js?date={{ date('ymdHis') }}"></script>

    </body>
</html>