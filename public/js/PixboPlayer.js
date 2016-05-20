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
  Client_ADDR : false,
  EnableControls : false,
  UpdatedAt : false,
  Screens : [],
  Vegas_Started : false,
  Backdrop : false,

  // DOM-connections holder
  DOM : {},

  // Start PixboPlayer
  Start : function(options){

    // Set Internal Values
    this.Client_ADDR    = (options && options.Client_ADDR) ? options.Client_ADDR : '';
    this.EnableControls = (options && options.EnableControls) ? options.EnableControls : false;

    // Setup Dom-connections
    this.DOM.VegasTarget  = $('body');
    this.DOM.TickerTarget = $('#ticker-container');

    // Start Standby-page
    this.Standby('Loading');

    this.Controls.Vegas.Init();

    // Check for updates every 10s
    setInterval( PixboPlayer.Sync, 1000*10 );

    // Run once with 'first start' set
    this.Sync(true);
  },

  // Standby-mode
  Standby : function(info){
    if (!this.Backdrop){
      this.Backdrop = document.createElement("canvas");
      this.Backdrop.style.position = "fixed";
      this.Backdrop.style.top = "0px";
      this.Backdrop.width = window.innerWidth;
      this.Backdrop.height = window.innerHeight;
      this.Backdrop.style.width = "100%";
      this.Backdrop.style.height = "100%";
      this.Backdrop.style.zIndex = "1000";
      this.Backdrop.ctx = this.Backdrop.getContext("2d");
      this.DOM.VegasTarget.append(this.Backdrop);
    }
    this.Backdrop.style.display = "block";
    
      this.Backdrop.ctx.textAlign = 'center';
      this.Backdrop.ctx.lineWidth = '10px';
      this.Backdrop.ctx.grd = this.Backdrop.ctx.createRadialGradient(0,0,50,0,0,this.Backdrop.width/2);
      this.Backdrop.ctx.grd.addColorStop(0,"#333");
      this.Backdrop.ctx.grd.addColorStop(1,"#000");

      this.Backdrop.ctx.info = info;

      PixboPlayer.Standby_Counter = 0;
      
    this.Standby_Animation = function(){
      PixboPlayer.requestFrame = requestAnimationFrame(PixboPlayer.Standby_Animation, PixboPlayer.Backdrop);
    //this.Standby_Animation = setInterval( function(){
      PixboPlayer.Backdrop.ctx.clearRect( 0, 0, PixboPlayer.Backdrop.width, PixboPlayer.Backdrop.height );
      PixboPlayer.Backdrop.ctx.save();

      PixboPlayer.Backdrop.ctx.translate( PixboPlayer.Backdrop.width/2, PixboPlayer.Backdrop.height/2 );

      PixboPlayer.Backdrop.ctx.fillStyle = PixboPlayer.Backdrop.ctx.grd;
      PixboPlayer.Backdrop.ctx.fillRect(
        -PixboPlayer.Backdrop.width/2,
        -PixboPlayer.Backdrop.height/2,
        PixboPlayer.Backdrop.width,
        PixboPlayer.Backdrop.height
      );

      PixboPlayer.Backdrop.ctx.strokeStyle = '#333';
      PixboPlayer.Backdrop.ctx.beginPath();
      PixboPlayer.Backdrop.ctx.arc(0,0,PixboPlayer.Backdrop.width/4,PixboPlayer.Standby_Counter/Math.PI,(PixboPlayer.Standby_Counter+15)/Math.PI);
      PixboPlayer.Backdrop.ctx.stroke();
      PixboPlayer.Standby_Counter+=0.02;
      if (PixboPlayer.Standby_Counter>=360)
        PixboPlayer.Standby_Counter = 0;

      PixboPlayer.Backdrop.ctx.font      = '96px Verdana';
      PixboPlayer.Backdrop.ctx.fillStyle = '#999';
      if (PixboPlayer.Backdrop.ctx.info=="404"){
        PixboPlayer.Backdrop.ctx.fillText( "Standby", 0, 0 );
        PixboPlayer.Backdrop.ctx.font      = '40px Verdana';
        PixboPlayer.Backdrop.ctx.fillText( PixboPlayer.Client_ADDR, 0, 70 );
      }
      else
        PixboPlayer.Backdrop.ctx.fillText( PixboPlayer.Backdrop.ctx.info, 0, 0 );

      PixboPlayer.Backdrop.ctx.restore();
    };
    //}, 1000/4 );
    this.Standby_Animation();

  },
  Ready : function(){
    PixboPlayer.requestFrame = false;
    //clearTimeout(this.Standby_Animation);
    this.Backdrop.style.display = "none";
  },

  // Replace Contents
  Set_Screens : function(new_screens){
    this.Screens = [];
    for (i=0 ; i<new_screens.length ; i++){
      this.Screens.push( { src: '/' + new_screens[i].image } );
    }
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
    
    // Check if there is any tickers
    if (!_target || _target.children().length<1)
      return console.log('No tickers...');
    
    // Run .ticker() Plugin
    target.ticker(this.Settings.Ticker);

    // Start Controls
    if (this.EnableControls)
      this.Controls.Ticker.Init();
  },

  /* Start Vegas */
  Start_Vegas : function(){
    // Check if there is any screens
    if (!this.Screens || this.Screens.length<1)
      return console.log('No Screens...');

    // Set current Screens
    this.Settings.Vegas.slides = this.Screens;

    // Restart
    if (this.Vegas_Started)
      this.DOM.VegasTarget          // Restart Player Chain
        .vegas('pause')             // Pause
        .vegas('destroy')           // Destroy
        .vegas(this.Settings.Vegas) // Start New
        .vegas('play');             // Play

    // First Run
    else
      this.DOM.VegasTarget
        .vegas(this.Settings.Vegas);
    
    this.Vegas_Started = true;
  },

  /* Update-check */
  Sync : function (first_run) {
      var _request = $.ajax({
          type: "get",
          url: "/play/" + PixboPlayer.Client_ADDR,
      });
      _request.done(function() {
          var _data = JSON.parse(_request.responseText); // Fetch JSON-output
          if(first_run || PixboPlayer.UpdatedAt != _data['updated_at']) { // First run / Newer data found, update player:
              var _mode = first_run ? false : 'restart'; // Tell Update() if it´s a first run or restart (Vegas needs to know)
              if (!first_run) {
                console.log('Client Updated, fetching newer data: (site: '+ PixboPlayer.Client_ADDR +', updated: '+ _data['updated_at'] +')');
              }
              PixboPlayer.Update(
                  _data['photo_list'],
                  _data['tickers'],
                  _data['updated_at'],
                  _data['settings'],
                  false
              );
              if (!first_run && _data['reboot']){
                console.log("Reloading Page");
                location.reload();
              }
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
      _request.error(function(xhr) {
        PixboPlayer.Update(
            false,
            false,
            false,
            false,
            xhr.status
        );
      });
  },

  /* Perform update */
  Update : function(new_screens, new_tickers, new_updated_at, new_settings, info) {
      
      // Info & Errors
      if (info)
        this.Standby(info);
      else
        this.Ready();

      // Apply settings
      this.Apply_Settings(new_settings);

      // Replace screens-list
      this.Set_Screens( new_screens );

      // Start/Restart Vegas
      this.Start_Vegas();
      
      // Replace contents in DOM for tickers
      this.Put_Tickers( new_tickers );

      // Load/Reload Ticker
      this.Start_Ticker();

      // Replace UpdatedAt
      this.UpdatedAt = new_updated_at;

      // Done
  },

  // Controls
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

