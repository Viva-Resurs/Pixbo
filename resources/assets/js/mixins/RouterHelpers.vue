/**
* Created by Christoffer Isenberg on 16-May-16.
*/


<script type="text/ecmascript-6">
    export default {
        methods: {
            goBack() {

                if ( this.$route.query.screengroup )
                    return router.go( { path:'/screengroups/'+this.$route.query.screengroup });
                if (this.$root && this.$root.history && this.$root.history.previous){
                    let prev = this.$root.history.previous.split('.')
                    if(prev[1] == 'create') {
                        router.go({name: prev[0] + '.index'});
                    }
                    else {
                        if(this.$root.history.params)
                            router.go({ name: this.$root.history.previous, params: this.$root.history.params});
                        else
                            router.go({ name: this.$root.history.previous});
                    }
                } else if (this.$root && this.$root.$route.path){
                    let path = this.$root.$route.path.split('/');
                    router.go({ name: path[1] + '.index' });
                }

            }
        }
    }
</script>