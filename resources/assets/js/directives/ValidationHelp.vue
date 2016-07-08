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

                if (this.form && !this.form.validationHelp){

                    $(this.inputElement).popover({

                        html : true,
                        
                        placement: 'bottom',
                        //content: "<i class='fa fa-exclamation-circle text-danger'></i> "+this.vm.trans('validation.'+errors[0])+"",
                        content: "<div>"+this.vm.trans('validation.'+errors[0])+"</div",
                        selector: "#"+this.inputElement.id,
                        trigger: 'manual'

                    }).popover('show');

                    // Set validationHelp so only one popover is shown
                    this.form.validationHelp = true;

                }

            }).bind(this);


            this.clearWarning = (function(){

                this.el.classList.remove('has-error');

                this.inputFeedback.style.display="none";

                $(this.inputElement).popover('destroy');

                if (this.form && this.form.validationHelp)
                    this.form.validationHelp = false;

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


            // Attach EventListeners when nested components are ready
            
            var self = this;

            this.vm.$nextTick(function(){

                self.inputElement.addEventListener('blur', self.clearWarning);
                self.inputElement.addEventListener('input', self.clearWarning);

                self.form = $(self.inputElement).closest('form')[0];

                self.form.addEventListener('submit', self.checkInput);

            })
            
        },

        unbind: function () {
            
            // Remove EventListeners
            
            this.inputElement.removeEventListener('blur', this.clearWarning);
            this.inputElement.removeEventListener('input', this.clearWarning);

            $(this.inputElement).closest('form')[0].removeEventListener('submit', this.checkInput)

        }

    }
</script>