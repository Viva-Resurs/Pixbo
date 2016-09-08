<script type="text/ecmascript-6">
/**
 *  @author ToxicTree
 */
    export default {
        deep: true,
        twoWay: true,
        bind: function() {
            // Setup State
            this.state = {
                model: this.arg,
                id: this.expression,
                field: this.el.name,
                value: this.el.value
            };
            
            var self = this;

            var isUniqueCheck = function(recursively) {

                var value = self.state.value;

                client({ path: '/validate', entity: self.state }).then(
                    function (response) {

                        // Check if value-update got lost in the delay while waiting for validation
                        if (self.state.value != value){
                            // If not called recursively, try again now
                            if (recursively != 'second_try')
                                isUniqueCheck('second_try');
                            // Exit
                            return;
                        }

                        // Not valid
                        if (response.entity!="1"){
                            self.el._vueFormCtrl.setVadility(false); // bypass the standard vue-form.validate()
                            self.el._vueFormCtrl.setVadility('is-unique',false); // set custom error
                        }

                        // Valid
                        else
                            self.el._vueFormCtrl.setVadility('is-unique',true); // remove custom error

                        // Trigger a change so vue-form will do it´s work
                        $(self.el).trigger('change');
                    },
                    function (error){
                        return false;
                    }
                );
            };

            this.handler = function() {

                // Update state
                self.state.value = self.el.value;

                // If timer is on, clear
                if (self.timer)
                    clearTimeout(self.timer);

                // Set timer now
                self.timer = setTimeout(isUniqueCheck, 200);

            };

            this.el.addEventListener('input', this.handler)
        },
        unbind: function () {
            this.el.removeEventListener('input', this.handler)
        }
    }
</script>