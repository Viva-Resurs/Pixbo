PixboPlayer.Start_Vegas = function(screens){

    // Replace screens
    this.Set_Screens(screens);

    // Check if there is any screens
    if (!this.Screens || this.Screens.length<1)
        return console.log('No Screens...');

    // Set current Screens
    this.Settings.Vegas.slides = this.Screens;

    // Restart
    if (this.Vegas_Started)
        this.DOM.VegasTarget            // Restart Player Chain
            .vegas('pause')             // Pause
            .vegas('destroy')           // Destroy
            .vegas(this.Settings.Vegas) // Start New
            .vegas('play');             // Play

    // First Run
    else
        this.DOM.VegasTarget
            .vegas(this.Settings.Vegas);

    this.Vegas_Started = true;

};

PixboPlayer.Set_Screens = function(screens){

    this.Screens = [];

    for (var i=0 ; i<screens.length ; i++)
        this.Screens.push( { src: '/' + screens[i] } );

};

PixboPlayer.Controls.Vegas = {

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
        PixboPlayer.Controls.Vegas.Pause();                                                         // Pause
    },

    Prev : function(){
        PixboPlayer.DOM.VegasTarget
            .vegas('options', 'transitionDuration', '100')                                          // Speed-up
            .vegas('previous')                                                                      // Show previous screen
            .vegas('options', 'transitionDuration', PixboPlayer.Settings.Vegas.transitionDuration); // Restore speed
        PixboPlayer.Controls.Vegas.Pause();                                                         // Pause
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

    }
};
