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
window.$ = window.jQuery = require('../vendor/jquery-2.1.3.min.js');
require('vegas');
require('../vendor/jquery.ticker.js');


window.PixboPlayer = {

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

require('./PixboPlayerCore/jQuery.live.js');
require('./PixboPlayerCore/PixboPlayer.ConnectionStatus.js');
require('./PixboPlayerCore/PixboPlayer.Settings.js');
require('./PixboPlayerCore/PixboPlayer.Standby.js');
require('./PixboPlayerCore/PixboPlayer.Sync.js');
require('./PixboPlayerCore/PixboPlayer.Ticker.js');
require('./PixboPlayerCore/PixboPlayer.Vegas.js');
