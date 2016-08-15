PixboPlayer.ConnectionStatus = function(){
    
    if (this.State === 0 ){

        if (!this.DOM.Warning){

          var Warning = document.createElement("div");
              Warning.style.position = "fixed";
              Warning.style.top = "5px";
              Warning.style.left = "5px";
              Warning.style.color = "#f00";
              Warning.classList.add('fa');
              Warning.classList.add('fa-warning');

          this.DOM.VegasTarget.append( Warning );

        }

        return false;

    }

    else if (this.DOM.Warning) {

        this.DOM.Warning.style.display = 'none';
        this.DOM.Warning = false;

    }

    return true;

};
