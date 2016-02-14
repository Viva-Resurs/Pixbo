<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" href="css/vendor/vegas.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/vendor/ticker-style.css" type="text/css" media="screen" />

        <script type="text/javascript" src="js/vendor/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/vendor/jquery.easing.min.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery.ticker.js"></script>


        <script type="text/javascript" src="js/vendor/vegas.js"></script>

        <style type="text/css">
html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
}

body {
    position: relative;
    background: #000;
    color: #fff;
    font: 1em Arial, sans-serif;
}

        </style>

        <script type="text/javascript">

            var minutes = 1;
            var ajax_call = function () {
                var client = $('#client_id').val();
                var request = $.ajax({
                    type: "get",
                    url: "/play/" + client,
                });
                request.done(function() {
                    var data = JSON.parse(request.responseText);
                    var tickers = data['tickers'];
                    var screens = data['photo_list'];
                    var updated_at = data['updated_at'];
                    if(updated_at != $('#updated_at').val()) {
                        update_player(screens, tickers, updated_at);

                        //$.supersized.vars.options.slides = screens;
                        //$.supersized.destroy

                    }
                    //console.log({screens: screens, tickers: tickers});
                    //$.supersized.vars.options.slides = screens;
                    console.log({'db': updated_at, site: $('#updated_at').val()})
                });
            }

            var interval = 1000 * 10;
            setInterval(ajax_call, interval);

            function update_player(screens, tickers, updated_at) {
                console.log('need to update player');
            };




        </script>
    </head>

    <body>
        <input type="hidden" name="client_id" id="client_id" class="form-control" value="{{ $client }}">
        <input type="hidden" name="updated_at" id="updated_at" class="form-control" value="{{ $updated_at }}">

        <div id="example">

        </div>

        @if( Count($tickers) > 0)
            <div id="controls-wrapper" style="position: absolute; top: 100%; margin-top: -10em;left:60%; margin-left: -44em;">
                <div class="ticker-wrapperino">
                    <ul id="js-news" class="js-hidden">
                        @foreach ($tickers as $ticker)
                            <li class="news-item">{{ $ticker->text }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <script type="text/javascript">

                $('#js-news').ticker({
                    speed: 0.10,           // The speed of the reveal
                    ajaxFeed: false,       // Populate jQuery News Ticker via a feed
                    feedUrl: false,        // The URL of the feed
                                            // MUST BE ON THE SAME DOMAIN AS THE TICKER
                    feedType: 'xml',       // Currently only XML
                    htmlFeed: true,        // Populate jQuery News Ticker via HTML
                    debugMode: true,       // Show some helpful errors in the console or as alerts
                                       // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
                    controls: false,        // Whether or not to show the jQuery News Ticker controls
                    titleText: '',   // To remove the title set this to an empty String
                    displayType: 'fade', // Animation type - current options are 'reveal' or 'fade'
                    direction: 'ltr',       // Ticker direction - current options are 'ltr' or 'rtl'
                    pauseOnItems: 10000,    // The pause on a news item before being replaced
                    fadeInSpeed: 600,      // Speed of fade in animation
                    fadeOutSpeed: 300      // Speed of fade out animation
                });

            </script>
        @endif


        <script type="text/javascript">

            var images = [
                @foreach($list as $element)
                    { src: "/{{ $element['image'] }}" },
                @endforeach
            ];
            $('body').vegas({
                preload: true,
                transitionDuration: 4000,
                delay: 10000,
                timer: false,
                slides: images,
                init: function(globalSettings) {
                    console.log("init...");
                }
            });
        </script>


    </body>

</html>