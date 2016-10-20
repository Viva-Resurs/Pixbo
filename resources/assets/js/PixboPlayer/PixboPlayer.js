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

    Client_ADDR : false,
    EnableControls : false,
    UpdatedAt : false,
    Screens : [],
    Vegas_Started : false,
    Backdrop : false,
    Controls : {},

    // DOM-connections holder
    DOM : {},

    // Start PixboPlayer
    Start : function(options){

        this.Client_ADDR    = (options && options.Client_ADDR) ? options.Client_ADDR : '';
        this.EnableControls = (options && options.EnableControls) ? options.EnableControls : false;

        // Setup Dom-connections
        this.DOM.VegasTarget  = $('body');

        this.DOM.VegasTarget.append("<div id='ticker-container'></div>");

        this.DOM.TickerTarget = $('#ticker-container');

        // Start Standby-page
        this.Standby('Loading');

        this.Controls.Vegas.Init();

        // Check for updates every 10s
        setInterval( PixboPlayer.Sync, 1000*10 );

        // Run once with 'first start' set
        this.Sync(true);
        
    }

};
