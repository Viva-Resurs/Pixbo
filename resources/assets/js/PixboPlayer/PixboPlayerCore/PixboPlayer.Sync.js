PixboPlayer.Sync = function (first_run) {

    var request = $.ajax({
        type: "get",
        url: "play/" + PixboPlayer.Client_ADDR,
        error: function(xhr) {

            PixboPlayer.State = xhr.status;

            PixboPlayer.Update( false, false, false, false, xhr.status );

        }
    });

    request.done(function(xhr) {

        var _data, need_sync = false;

        try {
            _data = JSON.parse(request.responseText); // Fetch JSON-output
        }
        catch (err) {
            console.error('Problem while parsing JSON: '+err)
            return false;
        }

        if (_data.length<2)
            return PixboPlayer.Update( false, false, false, false, "NOSCREENGROUP" );

        if (!first_run && PixboPlayer.RebuiltAt != _data.settings.updated.date ){
            console.log("Reloading Page");
            location.reload();
        }

        // Check if schedule has changed
        need_sync = PixboPlayer.CheckContents(_data.photo_list, _data.tickers);


        if (first_run || need_sync || PixboPlayer.State != xhr.status || PixboPlayer.UpdatedAt != _data['updated_at']) {

            PixboPlayer.State = xhr.status;

            if (!first_run)
                console.log('Client Updated, fetching newer data: (site: '+ PixboPlayer.Client_ADDR +', updated: '+ _data['updated_at'] +')');

            PixboPlayer.Update(
                _data['photo_list'],
                _data['tickers'],
                _data['updated_at'],
                _data['settings'],
                false
            );

            if (!_data['photo_list'] || _data['photo_list'].length<1)
                PixboPlayer.Update( false, false, false, false, "NOSCREEN" );

        }

    });

};

PixboPlayer.sameString = function(a, b){
    if (typeof a != 'string' || typeof b != 'string'){
        console.log('Not strings');
        return false;
    }
    if (a.length != b.length){
        console.log('Not same length: '+a.length+'!='+b.length);
        return false;
    }
    for (var i = 0 ; i < a.length ; i++){
        if (a[i] != b[i]){
            console.log('Detected unmatch at '+i+' '+a[i]+'!='+b[i]);
            return false;
        }
    }
    return true;
};

PixboPlayer.CheckContents = function(screens, tickers) {
    if (screens){
        if (PixboPlayer.Screens.length != screens.length){
            console.log('Length doesn´t match: '+PixboPlayer.Screens.length+'!='+screens.length);
            return true;
        }
        for (var i = 0 ; i < this.Screens.length ; i++){
            if (!PixboPlayer.sameString(PixboPlayer.Screens[i].src != screens[i])){
                console.log('Not same string:');
                console.log(PixboPlayer.Screens[i].src);
                console.log(screens[i]);
                return true;
            }
        }
    }
    //if (tickers){
    //    if (this.Tickers.length != tickers.length)
    //        return true;
    //    for (var i = 0 ; i < this.Tickers.length ; i++){
    //        if (!PixboPlayer.sameString(this.Tickers[i] != tickers[i]))
    //           return true;
    //    }
    //}
    return false;
};

PixboPlayer.Update = function(new_screens, new_tickers, new_updated_at, new_settings, info) {

    // Info & Errors
    if (info)
        return this.Standby(info);
    else
        this.Ready();

    // Check connection
    if (!this.ConnectionStatus())
        return;

    // Apply settings
    this.Settings.Set(new_settings);

    // Start/Restart Vegas
    this.Start_Vegas( new_screens );

    // Start Ticker
    this.Start_Ticker( new_tickers );

    // Replace UpdatedAt
    this.UpdatedAt = new_updated_at;

    // Replace RebuiltAt
    if (new_settings)
        this.RebuiltAt = new_settings.updated.date;

    // Done
};
