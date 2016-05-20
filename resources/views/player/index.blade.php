<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, user-scalable=no">
    
    <title>Pixbo::Player</title>
    
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'> <!-- TODO: Needs to be Downloaded Later -->
    <link rel="stylesheet" href="css/vendor/vegas.css">
    <link rel="stylesheet" href="css/vendor/ticker.css">
    <link rel="stylesheet" href="css/player.css">

    <script src="/js/vendor/jquery-2.1.3.min.js"></script>
    <script src="/js/vendor/vegas.min.js"></script>
    <script src="/js/vendor/jquery.ticker.js"></script>
    <script src="/js/PixboPlayer.js"></script>
</head>
<body>

<script>
  PixboPlayer.Start({
    Client_ID   : {{ $Client_ID }},
    Client_ADDR : "{{ $Client_ADDR }}",
    @if(isset($preview))
      EnableControls : true,
    @endif
  });
</script>

</body>
</html>
