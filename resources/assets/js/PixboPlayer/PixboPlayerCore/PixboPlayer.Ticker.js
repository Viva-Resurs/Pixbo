PixboPlayer.Start_Ticker = function(tickers){

    // Replace tickers in DOM
    this.Put_Tickers(tickers);

    // Get Target
    var target = this.DOM.TickerTarget.find('ul#ticker');

    // Check if there is any tickers
    if (!target || target.children().length<1)
        return console.log('No tickers...');

    // Run .ticker() Plugin
    target.webTicker(this.Settings.Ticker);

    // Start Controls
    //if (this.EnableControls)
    //    this.Controls.Ticker.Init();

};

PixboPlayer.Put_Tickers = function(tickers){

    var content = "<ul id='ticker' class='ticker-content'>";

    for (var i=0 ; i<tickers.length ; i++)
        content += "<li>" + tickers[i] + "</li>";

    content += "</ul>";

    this.DOM.TickerTarget.html(content);

};

PixboPlayer.Controls.Ticker = {

    Element : false,

    Buttons : {
        Prev      : false,
        Next      : false,
        PlayPause : false,
    },

    Init : function(){

        //var controls = document.createElement('div');
        //ticker_control

        // This will go through the plugins output and hook into things
        PixboPlayer.DOM.TickerTarget.find('.ticker-controls').each(function(){

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
                var click = function (e){

                    // Using a timer (so that the plugin got some time to do its work before check)
                    setTimeout(function(){

                        // Check play/pause status when ticker-controls are being used and update icon
                        if (PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.contains('paused')){

                            PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.remove('fa-pause');
                            PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.add('fa-play');

                        } else {

                            PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.add('fa-pause');
                            PixboPlayer.Controls.Ticker.Buttons.PlayPause.classList.remove('fa-play');

                        }

                    }, 400);

                };
                console.log(this);
                console.log(this.onclick);
                console.log($(this).data("events"))
                return;
                var originalClick = this.onclick;
                this.onclick = function(e){
                    originalClick(e);
                    click(e);
                }

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

    }

};
