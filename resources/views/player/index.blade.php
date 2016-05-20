<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, user-scalable=no">

    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'> <!-- Needs to be Downloaded Later -->
    <link rel="stylesheet" href="css/vendor/vegas.css">
    <link rel="stylesheet" href="css/vendor/ticker.css">
    <link rel="stylesheet" href="css/player.css">
</head>
<body>

@if(isset($preview))
    <input type="hidden" name="preview" id="preview" class="form-control" value="yes">
@endif
<input type="hidden" name="client_id" id="client_id" class="form-control" value="{{ $client }}">
<input type="hidden" name="updated_at" id="updated_at" class="form-control" value="{{ $updated_at }}">

<ul id="screens" style="display: none;">
    @foreach ($screens as $screen)
        <li src="{{ $screen['image'] }}"></li>
    @endforeach
</ul>

<div id="ticker-container">
    <ul id="ticker">
        @foreach ($tickers as $ticker)
            <li>{{ $ticker['text'] }}</li>
        @endforeach
    </ul>
</div>

<script src="/js/vendor/jquery-2.1.3.min.js"></script>
<script src="/js/vendor/vegas.min.js"></script>
<script src="/js/vendor/jquery.ticker.js"></script>
<script src="/js/PixboPlayer.js"></script>
<script> PixboPlayer.Start(); </script>
</body>
</html>