PixboPlayer.Settings = {
    
    Vegas : {
        preload: true,
        transitionDuration: 4000,
        delay: 10000,
        timer: true,
        slides: false // This property will be set in Start_Vegas()
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

    Set : function(settings){
        
        if (!settings)
            return;

        // Apply Vegas-settings
        if (settings.vegas)
            for (var property in settings.vegas)
                if (PixboPlayer.Settings.Vegas.hasOwnProperty(property))
                    PixboPlayer.Settings.Vegas[property] = Number( settings.vegas[property] );
        
        // Apply Ticker-settings
        if (settings.ticker)
            for (var property in settings.ticker)
                if (PixboPlayer.Settings.Ticker.hasOwnProperty(property))
                    PixboPlayer.Settings.Ticker[property] = Number( settings.ticker[property] );

        // Add Controls in Settings for Ticker
        if (PixboPlayer.EnableControls)
            PixboPlayer.Settings.Ticker.controls = true;

        // Add Controls for Vegas
        if (PixboPlayer.EnableControls)
            PixboPlayer.Controls.Vegas.Enable();

    }

};
