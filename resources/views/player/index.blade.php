<!DOCTYPE html>
<html>
    <head>
        <title>Pixbo::Player</title>

        <link rel="stylesheet" href="css/PixboPlayer.css?date={{ date('ymdHis') }}">
        
        <script src="/js/PixboPlayer.js?date={{ date('ymdHis') }}"></script>
    </head>
    <body>
        <script>
            PixboPlayer.Start({
                Client_ADDR : "{{ $Client_ADDR }}"
                
                @if(isset($preview))
                    , EnableControls : true
                @endif

            });
        </script>
    </body>
</html>
