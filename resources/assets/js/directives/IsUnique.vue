<script>
    export default {
        deep: true,
        twoWay: true,
        bind: function(){
            // Setup State
            this.state = {
                model: this.arg,
                id: this.expression,
                field: this.el.name,
                value: this.el.value
            };
            
            var self = this;

            var isUniqueCheck = function(){
                client({ path: '/validate', entity: self.state }).then(
                    function (response, status, request) {
                        if (response.entity!="1")
                            self.el._vueFormCtrl.setVadility(false);
                    },
                    function (response, status, request) {
                        if (status === 401)
                            self.$dispatch('userHasLoggedOut')
                    }
                )
            };


            this.handler = function () {
              // set data back to the vm.
              // If the directive is bound as v-example="a.b.c",
              // this will attempt to set `vm.a.b.c` with the
              // given value.
              this.set(this.el.value)
              
              this.state.value = this.el.value;

              setTimeout( (function(){ 
                  if (this.el.classList.contains('vf-valid'))
                    isUniqueCheck(this.el.value)
               }).bind(this), 100);

            }.bind(this)
            this.el.addEventListener('input', this.handler)
        },
        unbind: function () {
            this.el.removeEventListener('input', this.handler)
        }
    }
</script>