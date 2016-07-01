<script>
/**
 *  @author ToxicTree
 */
    export default {
        deep: true,
        twoWay: true,
        bind: function() {
            // TODO: Create popover-element

            this.handler = function() {
                // TODO: Get errors from vue-form
                /*
                var errors = self.el._vueFormCtrl.state; // .$error { isUnique, required, ... }
                console.log(errors)
                */
               
                // TODO: If error is found, trigger popover with content from error-name
                //       like this:   popover-content=trans('validation'+error)
                //                    popover('show')
                //       else
                //                    popover('hide')
            };

            this.el.addEventListener('input', this.handler)
        },
        unbind: function () {
            this.el.removeEventListener('input', this.handler)
        }
    }
</script>