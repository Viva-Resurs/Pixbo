<!DOCTYPE html>
<html>
    <head>
        <title>Pixbo::Admin</title>
        <base href="{{ substr($_SERVER['SCRIPT_NAME'],0,strripos($_SERVER['SCRIPT_NAME'],'/')+1) }}">
        <link rel="stylesheet" href="css/app.css?date={{ date('ymdHis') }}">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="js/index.js?date={{ date('ymdHis') }}"></script>
    </body>
</html>
