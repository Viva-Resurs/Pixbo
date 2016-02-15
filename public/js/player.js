
var $body       = $('body');
var $screens = $('#screens');
var $updated_at = $('#updated_at').val();
var $client_id = $('#client_id').val();
var backgrounds = [];
var newBackgrounds = [];

$('html').addClass('animated');

var displayBackdrops = false;


$screens.each(function() {
    $(this).find('li').each(function() {
        var current = $(this);
        bg = current.attr('src');
        backgrounds.push({
            src: '/' + bg
        });
    })

});

/*
var backgrounds = [
    { src: "/screens/images/$2y$10$HUabKjNqFsvOV3jsOp5ePuhUDIBag1zELC0BnMUx3OqwEgZ8SaZVa.png" },
    { src: "/screens/images/image_0.83359500 1455543895.png" }
];
*/

$body.vegas({
    preload: true,
    transitionDuration: 4000,
    delay: 10000,
    slides: backgrounds,
});


var minutes = 1;
var ajax_call = function () {
    $updated_at = $('#updated_at').val();
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
        if(updated_at != $updated_at) {
            console.log({site: $updated_at, db: updated_at});
            console.log('fetching newer data');
            update_player(screens, tickers, updated_at);


        }

    });
}

var interval = 1000 * 10;
setInterval(ajax_call, interval);

function update_player(screens, tickers, updated_at) {
    newBackgrounds = [];
    screens.forEach(function(entry) {
        newBackgrounds.push({src: entry.image})
    });

    console.log(newBackgrounds);
    $body.vegas('pause');
    $body.vegas('destroy');
    $('#updated_at').val(updated_at);

    $body.vegas({
        preload: true,
        transitionDuration: 4000,
        delay: 10000,
        slides: newBackgrounds,
    });
    $body.vegas('play');
};