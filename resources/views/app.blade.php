<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <script type="text/javascript" src="/js/vendor/jquery-2.1.3.min.js"></script>
    
    @include('shared.tooltip')
    @include('shared.datetimepicker')
    {{--
        @if ( Config::get('app.debug') )
            <script type="text/javascript">
                document.write('<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
            </script>
        @endif
    --}}
    @yield('header')
    @yield('links')
    @yield('styles')

</head>
<body id="app">
    
    <!-- top_nav -->
    @include('navs.topnav')
    
    <!-- body -->
    @yield('body')
    
    <script src="/js/main.js"></script>
    
    @yield('footer')

</body>
</html>
