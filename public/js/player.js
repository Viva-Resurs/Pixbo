
/*

    IMPORTANT NOTE:
    
    For demo purpose only.

    Except the Sin City Promotional Material and the downloadable Vegas plugin,
    any reproduction, even partial, of this design is strictly prohibited 
    without previous written authorisation from the author.

 */

/* jshint strict: false */

var $body       = $('body');

var backgrounds = [
    { src: "/screens/images/image_0.58178600%201455416274.jpg" },
    { src: "/screens/images/image_0.95800100%201455416352.jpg" }
];

$('html').addClass('animated');

var displayBackdrops = false;

$body.vegas({
    preload: true,
    transitionDuration: 4000,
    delay: 10000,
    slides: backgrounds,
    walk: function (nb, settings) {
        if (settings.video) {
            $('.logo').addClass('collapsed');
        } else {
            $('.logo').removeClass('collapsed');
        }
    }
});