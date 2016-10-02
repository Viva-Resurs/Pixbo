/* Setup DOM-connections */
var $vegas_target   = $('body');
var $ticker_target  = $('#ticker-container');
var $screens        = $('#screens');
var $updated_at     = $('#updated_at');
var $client_id      = $('#client_id');
var $preview        = $('#preview');

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


/** 
 * Forward port jQuery.live()
 * Wrapper for newer jQuery.on()
 * Uses optimized selector context 
 * Only add if live() not already existing.
 * Information: The live() method was deprecated in jQuery version 1.7,
 *              and removed in version 1.9.
 *              Use the on() method instead.
 * Reason: Ticker-plugin uses live() @control, forward function instead of refactor plugin.
*/
if (typeof jQuery.fn.live == 'undefined' || !(jQuery.isFunction(jQuery.fn.live))) {
  jQuery.fn.extend({
      live: function (event, callback) {
         if (this.selector) {
              jQuery(document).on(event, this.selector, callback);
          }
      }
  });
}


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
  // Add Controls in Ticker
  if ($preview.val())
    ticker_settings.controls=true;
  if ($ticker_target.find('ul#ticker').children().length>0){
    $ticker_target.find('ul#ticker').ticker(ticker_settings);
    if (ticker_settings.controls)
      ticker_control.init();
  }
  else
    console.log('No tickers...');
}


/* Start Vegas */
function start_vegas(mode){
  if ($preview.val())
    vegas_control.Enable(); // Add Controls for Vegas
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
ajax_call(true); // Run once with flag set

/* Control for Preview */
var vegas_control = {
    element : false,
    buttons : {
        prev : {
            element : false,
            action  : this.Prev
        },
        next : {
            element : false,
            action  : this.Next
        },
        play : {
            element : false,
            action  : this.Play
        },
        pause : {
            element : false,
            action  : this.Pause
        },
    },
    Enable : function(){
      vegas_control.element.style.display='block'; // Show
    },
    Play : function(){
        vegas_control.buttons.play.element.style.display = "none";
        vegas_control.buttons.pause.element.style.display = "block";
        $vegas_target.vegas('play'); // Play
    },
    Pause : function(){
        vegas_control.buttons.play.element.style.display = "block";
        vegas_control.buttons.pause.element.style.display = "none";
        $vegas_target.vegas('pause'); // Pause
    },
    Next : function(){
        $vegas_target
          .vegas('options', 'transitionDuration', '100') // Speed-up
          .vegas('next') // Show next screen
          .vegas('options', 'transitionDuration', vegas_settings.transitionDuration); // Restore speed
        vegas_control.Pause(); // Pause
    },
    Prev : function(){
        $vegas_target
          .vegas('options', 'transitionDuration', '100') // Speed-up
          .vegas('previous') // Show previous screen
          .vegas('options', 'transitionDuration', vegas_settings.transitionDuration); // Restore speed
        vegas_control.Pause(); // Pause
    },
};
vegas_control.init = function (){
    // Create Elements
    this.element = document.createElement("div");
      this.buttons.prev.element = document.createElement("a");
      this.buttons.next.element = document.createElement("a");
      this.buttons.play.element = document.createElement("a");
      this.buttons.pause.element = document.createElement("a");

    // Add Classes
    this.element.classList.add('vegas_control');
      this.buttons.prev.element.classList.add('glyphicon');
      this.buttons.prev.element.classList.add('glyphicon-chevron-left');
      this.buttons.next.element.classList.add('glyphicon');
      this.buttons.next.element.classList.add('glyphicon-chevron-right');
      this.buttons.play.element.classList.add('glyphicon');
      this.buttons.play.element.classList.add('glyphicon-play');
      this.buttons.pause.element.classList.add('glyphicon');
      this.buttons.pause.element.classList.add('glyphicon-pause');
    
    // Attach event-listeners
      this.buttons.prev.element.onclick = this.Prev;
      this.buttons.next.element.onclick = this.Next;
      this.buttons.play.element.onclick = this.Play;
      this.buttons.pause.element.onclick = this.Pause;

    // CSS
      this.buttons.play.element.style.display = "none"; // Play-button hidden on start
    this.element.style.display = "none"; // Hide Controls on start.

    // Append Elements
      this.element.appendChild(this.buttons.prev.element);
      this.element.appendChild(this.buttons.play.element);
      this.element.appendChild(this.buttons.pause.element);
      this.element.appendChild(this.buttons.next.element);
    $vegas_target.append(this.element);
};
vegas_control.init();

var ticker_control = {
    element : false,
    buttons : {
        prev : {
            element : false,
            action  : this.Prev
        },
        next : {
            element : false,
            action  : this.Next
        },
        play_pause : {
            element : false,
            action  : this.Toggle
        },
    },
};
ticker_control.init = function(){
    // This will go through the plugins output and hook into things
    $ticker_target.find('.ticker-controls').each(function(){
        this.classList.add('ticker_control');
        ticker_control.element = this;
        // Get Buttons and Attach event-listener
        $(this).find('li').each(function(){
            if (this.classList.contains('jnt-prev'))
                ticker_control.buttons.prev.element = this;
            if (this.classList.contains('jnt-next'))
                ticker_control.buttons.next.element = this;
            if (this.classList.contains('jnt-play-pause'))
                ticker_control.buttons.play_pause.element = this;
            this.onclick=function (e){
                // Timer (so that the plugin got some time to do its work before check)
                setTimeout(function(){
                    // Check status, toggle play/pause icon
                    if (ticker_control.buttons.play_pause.element.classList.contains('paused')){
                        ticker_control.buttons.play_pause.element.classList.remove('glyphicon-pause');
                        ticker_control.buttons.play_pause.element.classList.add('glyphicon-play');
                    } else {
                        ticker_control.buttons.play_pause.element.classList.add('glyphicon-pause');
                        ticker_control.buttons.play_pause.element.classList.remove('glyphicon-play');
                    }
                }, 100);
            };
        });
        // Add Classes
        ticker_control.buttons.prev.element.classList.add('glyphicon');
        ticker_control.buttons.prev.element.classList.add('glyphicon-chevron-left');
        ticker_control.buttons.next.element.classList.add('glyphicon');
        ticker_control.buttons.next.element.classList.add('glyphicon-chevron-right');
        ticker_control.buttons.play_pause.element.classList.add('glyphicon');
        ticker_control.buttons.play_pause.element.classList.add('glyphicon-pause');
        // Order Buttons
        $(ticker_control.buttons.play_pause.element).insertBefore(ticker_control.buttons.next.element);
    });
};