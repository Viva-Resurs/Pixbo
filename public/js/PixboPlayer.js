/* -----------------------------------------------------------------------------
 * PixboPlayer.js, written by Jonathan Timmerlid
 *
 * 
 * 
 * Documentation about used plugins:
 * Ticker : http://www.jquerynewsticker.com/
 * Vegas  : http://vegas.jaysalvat.com/documentation/
 * -----------------------------------------------------------------------------
 */

var PixboPlayer = {

  // Internal
  EnableControls : false,

  // DOM-connections holder
  DOM : {},

  // Start PixboPlayer
  Start : function(){

    // Setup Dom-connections
    this.DOM.VegasTarget  = $('body');
    this.DOM.TickerTarget = $('#ticker-container');
    this.DOM.ScreenBox    = $('#screens');
    this.DOM.UpdatedAt    = $('#updated_at');
    this.DOM.ClientID     = $('#client_id');
    this.DOM.Preview      = $('#preview');
    
    this.Controls.Vegas.Init();

    // Check for updates every 10s
    setInterval( this.Sync, 1000*10 );

    // Run once with 'first start' set
    this.Sync(true);
  },

  // DOM-Access
  Get_Screens : function(){
    var images = [];
    this.DOM.ScreenBox.find('li').each(function() {
        images.push(
            { src: '/' + $(this).attr('src') }
        );
    });
    return images;
  },

  // DOM-Replacement
  Put_Screens : function(screens){
    var new_content = '';
    for (i=0 ; i<screens.length ; i++){
        new_content += "<li src='"+screens[i].image+"'></li>";
    }
    this.DOM.ScreenBox.html(new_content); // Replace content in ScreenBox Element
  },
  Put_Tickers : function(tickers){
    var new_content = "<ul id='ticker'>";
    for (i=0 ; i<tickers.length ; i++){
        new_content += "<li>"+tickers[i].text+"</li>";
    }
    new_content += "</ul>";
    this.DOM.TickerTarget.html(new_content); // Replace content in Ticker Element
  },

  // Settings & Defaults
  Settings : {
    Vegas : {
      preload: true,
      transitionDuration: 4000,
      delay: 10000,
      slides: false /* This property will be set in Start_Vegas()
        [
          { src: "/screens/images/$2y$10$HUabKjNqFsvOV3jsOp5ePuhUDIBag1zELC0BnMUx3OqwEgZ8SaZVa.png" },
          { src: "/screens/images/image_0.83359500 1455543895.png" }
        ]
      */
    },
    Ticker : {
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
    },
  },
  Apply_Settings : function(new_settings){
    // Enable Controls
    if (this.DOM.Preview.val())
      this.EnableControls = true;
    
    // Apply Vegas-settings
    if (new_settings.vegas)
      for (var property in this.Settings.Vegas)
        if (this.Settings.Vegas.hasOwnProperty(property))
          this.Settings.Vegas[property] = new_settings.vegas[property];
    
    // Apply Ticker-settings
    if (new_settings.ticker)
      for (var property in this.Settings.Ticker)
        if (this.Settings.Ticker.hasOwnProperty(property))
          this.Settings.Ticker[property] = new_settings.ticker[property];

    // Add Controls in Settings for Ticker
    if (this.EnableControls)
      this.Settings.Ticker.controls=true;

    // Add Controls for Vegas
    if (this.EnableControls)
      this.Controls.Vegas.Enable();
  },

  /* Start Ticker */
  Start_Ticker : function(){
    // Get Target
    var _target = this.DOM.TickerTarget.find('ul#ticker');

    // Check for tickers
    if (_target.children().length>0){
      // Run .ticker() Plugin
      _target.ticker(this.Settings.Ticker);

      // Start Controls
      if (this.EnableControls)
        this.Controls.Ticker.Init();
    }
    else{
      // No Tickers
      console.log('No tickers...');
    }
  },

  /* Start Vegas */
  Start_Vegas : function(mode){
    // Get current Screens
    this.Settings.Vegas.slides = this.Get_Screens();

    // Check if there is any screens
    if (this.Settings.Vegas.slides.length<1)
      return console.error('No Screens...');

    // Restart
    if (mode=='restart')
      this.DOM.VegasTarget          // Restart Player Chain
        .vegas('pause')             // Pause
        .vegas('destroy')           // Destroy
        .vegas(this.Settings.Vegas) // Start New
        .vegas('play');             // Play

    // First Run
    else
      this.DOM.VegasTarget
        .vegas(this.Settings.Vegas);
  },

  /* Update-check */
  Sync : function (first_run) {
      var _request = $.ajax({
          type: "get",
          url: "/play/" + PixboPlayer.DOM.ClientID.val(),
      });
      _request.done(function() {
          var _data = JSON.parse(_request.responseText); // Fetch JSON-output
          if(first_run || PixboPlayer.DOM.UpdatedAt.val() != _data['updated_at']) { // First run / Newer data found, update player:
              var _mode = first_run ? false : 'restart'; // Tell Update() if it´s a first run or restart (Vegas needs to know)
              if (!first_run) {
                console.log('Client Updated, fetching newer data: (site: '+ PixboPlayer.DOM.ClientID.val() +', updated: '+ _data['updated_at'] +')');
              }
              PixboPlayer.Update(
                  _data['photo_list'],
                  _data['tickers'],
                  _data['updated_at'],
                  _data['settings'],
                  _mode
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
  },

  /* Perform update */
  Update : function(new_screens, new_tickers, new_updated_at, new_settings, mode) {
      
      // Apply settings
      this.Apply_Settings(new_settings);

      // Replace contents in DOM for screens-list
      this.Put_Screens( new_screens );

      // Start/Restart Vegas
      this.Start_Vegas(mode);
      
      // Replace contents in DOM for tickers
      this.Put_Tickers( new_tickers );

      // Load/Reload Ticker
      this.Start_Ticker();

      // Replace value of updated_at
      this.DOM.UpdatedAt.val(new_updated_at);

      // Done
  },

  // Controls in Preview-mode
  Controls : {
    Vegas : {
      Element : false,
      Buttons : {
        Prev  : false,
        Next  : false,
        Play  : false,
        Pause : false,
      },

      // Show Controls
      Enable : function(){
        this.Element.style.display='block';
      },

      // Functions
      Play : function(){
        PixboPlayer.Controls.Vegas.Buttons.Play.style.display = "none";
        PixboPlayer.Controls.Vegas.Buttons.Pause.style.display = "block";
        PixboPlayer.DOM.VegasTarget.vegas('play');
      },
      Pause : function(){
        PixboPlayer.Controls.Vegas.Buttons.Play.style.display = "block";
        PixboPlayer.Controls.Vegas.Buttons.Pause.style.display = "none";
        PixboPlayer.DOM.VegasTarget.vegas('pause');
      },
      Next : function(){
        PixboPlayer.DOM.VegasTarget
          .vegas('options', 'transitionDuration', '100')                                          // Speed-up
          .vegas('next')                                                                          // Show next screen
          .vegas('options', 'transitionDuration', PixboPlayer.Settings.Vegas.transitionDuration); // Restore speed
        PixboPlayer.Controls.Vegas.Pause();                                                       // Pause
      },
      Prev : function(){
        PixboPlayer.DOM.VegasTarget
          .vegas('options', 'transitionDuration', '100')                                          // Speed-up
          .vegas('previous')                                                                      // Show previous screen
          .vegas('options', 'transitionDuration', PixboPlayer.Settings.Vegas.transitionDuration); // Restore speed
        PixboPlayer.Controls.Vegas.Pause();                                                       // Pause
      },

      Init : function (){
        // Create Elements
        this.Element = document.createElement("div");
          this.Buttons.Prev  = document.createElement("a");
          this.Buttons.Next  = document.createElement("a");
          this.Buttons.Play  = document.createElement("a");
          this.Buttons.Pause = document.createElement("a");

        // Add Classes
        this.Element.classList.add('vegas_control');
          this.Buttons.Prev.classList.add('fa');
          this.Buttons.Prev.classList.add('fa-step-backward');
          this.Buttons.Next.classList.add('fa');
          this.Buttons.Next.classList.add('fa-step-forward');
          this.Buttons.Play.classList.add('fa');
          this.Buttons.Play.classList.add('fa-play');
          this.Buttons.Pause.classList.add('fa');
          this.Buttons.Pause.classList.add('fa-pause');
        
        // Attach event-listeners
          this.Buttons.Prev.onclick  = this.Prev;
          this.Buttons.Next.onclick  = this.Next;
          this.Buttons.Play.onclick  = this.Play;
          this.Buttons.Pause.onclick = this.Pause;

        // CSS
          this.Buttons.Play.style.display = "none"; // Play-button hidden on start
        this.Element.style.display = "none"; // Hide Controls on start.

        // Append Elements
          this.Element.appendChild(this.Buttons.Prev);
          this.Element.appendChild(this.Buttons.Play);
          this.Element.appendChild(this.Buttons.Pause);
          this.Element.appendChild(this.Buttons.Next);
        PixboPlayer.DOM.VegasTarget.append(this.Element);
      },
    },
    Ticker : {
      Element : false,
      Buttons : {
             Prev : false,
             Next : false,
        PlayPause : false,
      },

      Init : function(){
        // This will go through the plugins output and hook into things
        this.DOM.TickerTarget.find('.ticker-controls').each(function(){
          // Got ticker-controls element
          PixboPlayer.Controls.Ticker.Element = this;
          this.classList.add('ticker_control');

          // Collect Buttons
          $(this).find('li').each(function(){
            if (this.classList.contains('jnt-prev'))
              PixboPlayer.Controls.Ticker.Buttons.Prev = this;
            if (this.classList.contains('jnt-next'))
              PixboPlayer.Controls.Ticker.Buttons.Next = this;
            if (this.classList.contains('jnt-play-pause'))
              PixboPlayer.Controls.Ticker.Buttons.PlayPause = this;
            
            // Attach event-listener
            this.onclick=function (e){
              // Timer (so that the plugin got some time to do its work before check)
              setTimeout(function(){
                // Check play/pause status when ticker-controls are being used and update icon
                if (PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.contains('paused')){
                  PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.remove('fa-pause');
                  PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.add('fa-play');
                } else {
                  PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.add('fa-pause');
                  PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.remove('fa-play');
                }
              }, 100);
            };
          });
          
          // Add Classes
          PixboPlayer.Controls.Ticker.Buttons.Prev.classList.add('fa');
          PixboPlayer.Controls.Ticker.Buttons.Prev.classList.add('fa-step-backward');
          PixboPlayer.Controls.Ticker.Buttons.Next.classList.add('fa');
          PixboPlayer.Controls.Ticker.Buttons.Next.classList.add('fa-step-forward');
          PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.add('fa');
          PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.add('fa-pause');
          
          // Order Buttons
          $( PixboPlayer.Controls.Ticker.Buttons.PlayPause ).insertBefore( PixboPlayer.Controls.Ticker.Buttons.Next );
        });
      },
    },
  },
};

/** 
 * Forward function jQuery.live()
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

