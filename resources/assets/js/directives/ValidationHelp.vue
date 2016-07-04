<script>
/**
 *  @author ToxicTree
 */
    export default {

        bind: function() {

            // DOM
            
            this.inputElement = $(this.el).find('input')[0];
            this.inputFeedback = document.createElement('span');

            $(this.inputElement).parent().append(this.inputFeedback);


            // Initial CSS
            
            this.el.classList.add('has-feedback');
            this.inputFeedback.classList.add('fa','fa-warning','form-control-feedback');
            this.inputFeedback.style.display="none";

            
            // Functions

            this.addWarning = (function(errors){

                this.el.classList.add('has-error');

                this.inputFeedback.style.display="inline";

                $(this.inputElement).popover({

                    content: this.vm.trans('validation.'+errors[0]),
                    selector: "#"+this.inputElement.id,
                    trigger: 'manual'

                }).popover('show');

            }).bind(this);


            this.clearWarning = (function(){

                this.el.classList.remove('has-error');

                this.inputFeedback.style.display="none";

                $(this.inputElement).popover('destroy');

            }).bind(this);


            this.checkInput = (function() {

                var errors = [];

                for (var error in this.inputElement._vueFormCtrl.state.$error)
                    errors.push(error);

                if (errors.length>0)
                    this.addWarning(errors);
                
                else
                    this.clearWarning();

            }).bind(this);


            // Attach EventListeners
            
            this.inputElement.addEventListener('blur', this.clearWarning);
            this.inputElement.addEventListener('input', this.clearWarning);

            $(this.inputElement).closest('form')[0].addEventListener('submit', this.checkInput)
            
        },

        unbind: function () {
            
            // Remove EventListeners
            
            this.inputElement.removeEventListener('blur', this.clearWarning);
            this.inputElement.removeEventListener('input', this.clearWarning);

            $(this.inputElement).closest('form')[0].removeEventListener('submit', this.checkInput)

        }

    }
</script>