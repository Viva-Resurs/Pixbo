<script>
/**
 *  @author ToxicTree
 */
    export default {
        deep: true,
        twoWay: true,
        bind: function() {
            // Setup State
            this.state = {
                value: this.el.value,
                check: false
            };
            
            var self = this;

            var isEqualCheck = function(recursively) {

                if (self.state.value != self.state.check){
                    self.el._vueFormCtrl.setVadility(false); // bypass the standard vue-form.validate()
                    self.el._vueFormCtrl.setVadility('is-equal',false); // set custom error
                }
                else
                    self.el._vueFormCtrl.setVadility('is-equal',true); // remove custom error
                
                // Trigger a change so vue-form will do it´s work
                $(self.el).trigger('change');

            };

            this.handler = function() {

                // Update elements value
                self.state.value = self.el.value;

                // If timer is on, clear
                if (self.timer)
                    clearTimeout(self.timer);

                // Set timer now
                self.timer = setTimeout(isEqualCheck, 200);

            };

            this.el.addEventListener('input', this.handler)
        },
        update: function(value){
            // Update expression value
            this.state.check = value;
        },
        unbind: function () {
            this.el.removeEventListener('input', this.handler)
        }
    }
</script>