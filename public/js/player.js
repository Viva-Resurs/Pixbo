/* Setup DOM-connections */
var $vegas_target   = $('body');
var $ticker_target  = $('#ticker-container');
var $screens        = $('#screens');
var $updated_at     = $('#updated_at');
var $client_id      = $('#client_id');


/* Settings & Defaults */
var vegas_settings = {
    preload: true,
    transitionDuration: 4000,
    delay: 10000,
    slides: false /* This property will be set in start_vegas()
      [
        { src: "/screens/images/$2y$10$HUabKjNqFsvOV3jsOp5ePuhUDIBag1zELC0BnMUx3OqwEgZ8SaZVa.png" },
        { src: "/screens/images/image_0.83359500 1455543895.png" }
      ]
    */
};
var ticker_settings = {
    speed: 0.10,           // The speed of the reveal
    ajaxFeed: false,       // Populate jQuery News Ticker via a feed
    feedUrl: false,        // The URL of the feed
                           // MUST BE ON THE SAME DOMAIN AS THE TICKER
    feedType: 'xml',       // Currently only XML
    htmlFeed: true,        // Populate jQuery News Ticker via HTML
    debugMode: true,       // Show some helpful errors in the console or as alerts
                           // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
    controls: false,       // Whether or not to show the jQuery News Ticker controls
    titleText: '',         // To remove the title set this to an empty String
    displayType: 'fade',   // Animation type - current options are 'reveal' or 'fade'
    direction: 'ltr',      // Ticker direction - current options are 'ltr' or 'rtl'
    pauseOnItems: 10000,   // The pause on a news item before being replaced
    fadeInSpeed: 600,      // Speed of fade in animation
    fadeOutSpeed: 300      // Speed of fade out animation
};

/* Apply custom settings */
function apply_settings(settings){
    for (var property in settings['vegas']) {
        if (settings['vegas'].hasOwnProperty(property))
          vegas_settings[property] = settings['vegas'][property];
    }
    for (var property in settings['ticker']) {
        if (settings['ticker'].hasOwnProperty(property))
          ticker_settings[property] = settings['ticker'][property];
    }
}


/* Documentation */
// Ticker : http://www.jquerynewsticker.com/
// Vegas  : http://vegas.jaysalvat.com/documentation/


/* Functions for access & changes in DOM */
function get_screens_from(element){
    var images = [];
    element.find('li').each(function() {
        images.push(
            { src: '/' + $(this).attr('src') }
        );
    })
    return images;
};
function put_screens_in(element,screens){
    var new_content = '';
    for (i=0 ; i<screens.length ; i++){
        new_content += "<li src='"+screens[i].image+"'></li>";
    }
    element.html(new_content); // Replace content in element
};
function put_tickers_in(element,tickers){
    var new_content = "<ul id='ticker'>";
    for (i=0 ; i<tickers.length ; i++){
        new_content += "<li>"+tickers[i].text+"</li>";
    }
    new_content += "</ul>";
    element.html(new_content); // Replace content in element
};


/* Start Ticker */
function start_ticker(){
  $ticker_target.find('#ticker').ticker(ticker_settings);
}


/* Start Vegas */
function start_vegas(mode){
  vegas_settings.slides = get_screens_from( $screens ); // Select current images
  if (mode=='restart')
    $vegas_target            // Restart Player Chain
      .vegas('pause')        // Pause
      .vegas('destroy')      // Destroy
      .vegas(vegas_settings) // Start New
      .vegas('play');        // Play
  else
    $vegas_target.vegas(vegas_settings); // First start
}


/* Update-check */
var ajax_call = function (first_run) {
    var request = $.ajax({
        type: "get",
        url: "/play/" + $client_id.val(),
    });
    request.done(function() {
        var data = JSON.parse(request.responseText); // Fetch JSON-output
        if(first_run || $updated_at.val() != data['updated_at']) { // First run / Newer data found, update player:
            var mode = first_run ? false : 'restart'; // Tell update_player() if it´s a first run or restart (Vegas needs to know)
            if (!first_run) {
              console.log('Client Updated, fetching newer data: (site: '+ $client_id.val() +', updated: '+ data['updated_at'] +')');
            }
            update_player(
                data['photo_list'],
                data['tickers'],
                data['updated_at'],
                data['settings'],
                mode
            );
            /*
            JSON-object structure: {
              "photo_list":[ {"image":" "}, ... ],
              "tickers":[ {"text":" "}, ... ],
              "updated_at":" ",
              "settings":{
                "ticker":{ "pauseOnItems":10000, ... },
                "vegas":{ "delay":10000, ... }
              }
            }
            */
        }
    });
}
ajax_call(true); // Run once with flag set
setInterval( ajax_call, 1000*10 ); // Check for newer data each 10 sec

/* Perform update */
function update_player(new_screens, new_tickers, new_updated_at, new_settings, mode) {
    
    // Apply settings
    apply_settings(new_settings);

    // Replace contents in DOM for screens-list
    put_screens_in( $screens, new_screens );

    // Start/Restart Vegas
    start_vegas(mode);
    
    // Replace contents in DOM for tickers
    put_tickers_in( $ticker_target, new_tickers );

    // Load/Reload Ticker
    start_ticker();

    // Replace value of updated_at
    $updated_at.val(new_updated_at);

    // Done
};