<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, user-scalable=no">

    <link rel="stylesheet" href="css/vendor/vegas.css">
    <link rel="stylesheet" href="css/vendor/ticker.css">
    <link rel="stylesheet" href="css/player.css">
</head>
<body>
    <div class="container">
        <input type="hidden" name="client_id" id="client_id" class="form-control" value="{{ $client }}">
        <input type="hidden" name="updated_at" id="updated_at" class="form-control" value="{{ $updated_at }}">
        @include('player.vegas')
        @include('player.ticker')
    </div>

    <script src="/js/vendor/jquery-2.1.3.min.js"></script>
    <script src="/js/vendor/vegas.min.js"></script>
    <script src="/js/vendor/ticker.js"></script>
    <script src="/js/player.js"></script>
</body>
</html>