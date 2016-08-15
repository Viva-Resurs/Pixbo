PixboPlayer.Standby = function(info){
    
    var _createBackdrop = function(){

        var Backdrop = document.createElement("canvas");
        
        Backdrop.id = "Backdrop";

        Backdrop.style.position = "fixed";
        Backdrop.style.top = "0px";
        Backdrop.style.width = "100%";
        Backdrop.style.height = "100%";
        Backdrop.style.zIndex = "1000";

        Backdrop.ctx = Backdrop.getContext("2d");
        
        Backdrop.show = function(){
            this.style.display = "block";
        };

        Backdrop.hide = function(){
            this.ctx.info = false;
            this.style.display = "none";
        };

        Backdrop.resize = function(){
            this.width = window.innerWidth;
            this.height = window.innerHeight;
        };

        // When resizing window
        window.onresize = (Backdrop.resize).bind(Backdrop);

        // Resize now
        Backdrop.resize();

        // Animation Position
        var position = 0;

        // Draw info
        Backdrop.ctx.draw = function(){

            this.clearRect( 0, 0, this.canvas.width, this.canvas.height );
            
            this.save();

            this.translate( this.canvas.width/2, this.canvas.height/2 );

            // Draw a background
            var grd = this.createRadialGradient( 0, 0, 50, 0, 0, this.canvas.width/2 );
                grd.addColorStop(0,"#333");
                grd.addColorStop(1,"#000");

            this.fillStyle = grd;

            this.fillRect( -this.canvas.width/2, -this.canvas.height/2, this.canvas.width, this.canvas.height );

            // Draw a spinner
            this.strokeStyle = '#333';
            this.lineWidth = '10px';

            this.beginPath();
            this.arc( 0, 0, this.canvas.width/4, position/Math.PI, (position+15)/Math.PI );
            this.stroke();

            position = (position>=360) ? 0 : position+0.02;

            // Draw some info
            this.font      = '96px Verdana';
            this.fillStyle = '#999';
            this.textAlign = "center"; 
            switch (this.info){
                case 404: {
                    this.fillText( "Klient saknas", 0, 0 );
                    this.font = '40px Verdana';
                    this.fillText( PixboPlayer.Client_ADDR, 0, 70 );
                    break;
                }
                case 500: {
                    this.fillText( "Server problem", 0, 0 );
                    this.font = '40px Verdana';
                    this.fillText( PixboPlayer.Client_ADDR, 0, 70 );
                    break;
                }
                case "NOSCREEN": {
                    this.fillText( "Standby", 0, 0 );
                    this.font = '40px Verdana';
                    this.fillText( 'Inga bilder...', 0, 70 );
                    break;
                }
                default:
                    this.fillText( this.info, 0, 0 );
            }

            this.restore();

        };

        // Append
        PixboPlayer.DOM.VegasTarget.append(Backdrop);
        PixboPlayer.Backdrop = Backdrop;

        // Done
        PixboPlayer.Backdrop.show();
    };


    if (!this.Backdrop)
        _createBackdrop();
    
    else
        this.Backdrop.show();

    // Update Info
    this.Backdrop.ctx.info = info;

    // Quit backdrop
    this.Ready = function(){
        PixboPlayer.requestFrame = false;
        PixboPlayer.Backdrop.hide();
    }

    // Animation-Loop
    this.StandbyLoop = function(){
        PixboPlayer.requestFrame = requestAnimationFrame( PixboPlayer.StandbyLoop, PixboPlayer.Backdrop );
        PixboPlayer.Backdrop.ctx.draw();
    };

    // Start the Animation
    this.StandbyLoop();
};

PixboPlayer.Ready = function(){
    
    if (PixboPlayer.Backdrop)
        PixboPlayer.Backdrop.hide();

    PixboPlayer.requestFrame = false;

};
