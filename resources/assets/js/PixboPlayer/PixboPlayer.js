/* -----------------------------------------------------------------------------
 * PixboPlayer.js, written by Jonathan Timmerlid
 *
 *
 *
 * Documentation about used plugins:
 * Vegas     : http://vegas.jaysalvat.com/documentation/
 * webticker : https://maze.digital/webticker/
 * -----------------------------------------------------------------------------
 */
window.$ = window.jQuery = require('jquery');
require('vegas');
require('webticker/jquery.webticker.js');


window.PixboPlayer = {

    Client_ADDR : false,
    EnableControls : false,
    UpdatedAt : false,
    Screens : [],
    Tickers : [],
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

        this.DOM.VegasTarget.append("<div id='ticker-container' class='ticker-wrapper'></div>");

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

require('./PixboPlayerCore/PixboPlayer.ConnectionStatus.js');
require('./PixboPlayerCore/PixboPlayer.Settings.js');
require('./PixboPlayerCore/PixboPlayer.Standby.js');
require('./PixboPlayerCore/PixboPlayer.Sync.js');
require('./PixboPlayerCore/PixboPlayer.Ticker.js');
require('./PixboPlayerCore/PixboPlayer.Vegas.js');
