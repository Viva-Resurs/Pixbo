<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" href="css/vendor/vegas.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/vendor/ticker-style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/player.css" type="text/css" media="screen" />

        <script type="text/javascript" src="js/vendor/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/vendor/jquery.easing.min.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery.ticker.js"></script>


        <script type="text/javascript" src="js/vendor/vegas.js"></script>

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

        <script type="text/javascript">

            var backgrounds = [
                    { src: "/{{ $list[0]['image'] }}", cover: false },
                    { src: "/{{ $list[1]['image'] }}" }
            ];
            /*
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
            */
           var $body = $('body');
           $('html').addClass('animated');

            $body.vegas({
                slides: backgrounds,
                preload: true,
                delay: 10000,
                transitionDuration: 4000,
                timer:true,
                init: function(globalSettings) {
                    console.log("init...");
                },
                play: function(index, slideSettings) {
                    console.log("Play: " + index);
                },
                walk: function(index, slideSettings) {
                    console.log("Slide index: " + index + " image: " + slideSettings.src);
                }
            });
        </script>






    </body>

</html>