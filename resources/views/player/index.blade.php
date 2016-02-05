<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" href="css/vendor/supersized.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/vendor/ticker-style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/vendor/supersized.shutter.css" type="text/css" media="screen" />

        <script type="text/javascript" src="js/vendor/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/vendor/jquery.easing.min.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery.ticker.js"></script>


        <script type="text/javascript" src="js/vendor/supersized.3.2.7.min.js"></script>
        <script type="text/javascript" src="js/vendor/supersized.shutter.min.js"></script>

        <script type="text/javascript">

            jQuery(function($){

                $.supersized({

                    // Functionality
                    slideshow               :   1,          // Slideshow on/off
                    autoplay                :   1,          // Slideshow starts playing automatically
                    start_slide             :   1,          // Start slide (0 is random)
                    stop_loop               :   0,          // Pauses slideshow on last slide
                    random                  :   0,          // Randomize slide order (Ignores start slide)
                    slide_interval          :   15000,       // Length between transitions
                    transition              :   6,          // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed        :   1000,       // Speed of transition
                    new_window              :   1,          // Image links open in new window/tab
                    pause_hover             :   0,          // Pause slideshow on hover
                    keyboard_nav            :   1,          // Keyboard navigation on/off
                    performance             :   1,          // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                    image_protect           :   1,          // Disables image dragging and right click with Javascript

                    // Size & Position
                    min_width               :   0,          // Min width allowed (in pixels)
                    min_height              :   0,          // Min height allowed (in pixels)
                    vertical_center         :   1,          // Vertically center background
                    horizontal_center       :   1,          // Horizontally center background
                    fit_always              :   1,          // Image will never exceed browser width or height (Ignores min. dimensions)
                    fit_portrait            :   1,          // Portrait images will not exceed browser height
                    fit_landscape           :   0,          // Landscape images will not exceed browser width

                    // Components
                    slide_links             :   'false',    // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    thumb_links             :   0,          // Individual thumb links for each slide
                    thumbnail_navigation    :   0,          // Thumbnail navigation
                    slides                  :   [           // Slideshow Images
                                                        @foreach ($list as $element)
                                                            {image : '{{ $element["path"] }}', title : '{$element->name}', thumb : '{$element->thumb_path}', url : ''},
                                                        @endforeach
                                                ],

                    // Theme Options
                    progress_bar            :   0,          // Timer for each slide
                    mouse_scrub             :   0,
                });
            });

        </script>
        <style type="text/css">
            .ticker-contrainer {
                position:fixed;bottom:0px;width:100%;
                height: 100%
                width: 100%;
            }
            .ticker-wrapperino {
                height: 100%;
                width: 100%;
                margin-right:auto;margin-left:auto;
            }
        </style>

    </head>

    <body>

        @if( Count($tickers) > 0)
        <div class="ticker-container">
            <div class="ticker-wrapperino">
                <ul id="js-news" class="js-hidden">
                    @foreach ($tickers as $ticker)
                        <li class="news-item">{{ $ticker->text }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif



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


    </body>

</html>