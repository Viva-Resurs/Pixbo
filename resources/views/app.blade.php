<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="/css/app.css">



    @yield('links')
    @yield('styles')

<!-- Application files
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
 -->
</head>
<body>

    <!-- top_nav -->
    @include('navs.topnav')

    <!-- body -->
    @yield('body')
    @yield('footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/js/bootstrap.js"></script>
</body>
</html>