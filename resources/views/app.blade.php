<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    @yield('links')
    @yield('styles')
    <style>
        body {
          padding-top: 70px;
          padding-bottom: 30px;
      }

      .theme-dropdown .dropdown-menu {
          position: static;
          display: block;
          margin-bottom: 20px;
      }

      .theme-showcase > p > .btn {
          margin: 5px 0;
      }

      .theme-showcase .navbar .container {
          width: auto;
      }
</style>
<!-- Application files -->
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>

</head>
<body>

    <!-- top_nav -->
    @include('navs.topnav')
    <!--  errors -->

    @yield('body')
    @yield('footer')

</body>
</html>