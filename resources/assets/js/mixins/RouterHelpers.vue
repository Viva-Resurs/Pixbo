/**
* Created by Christoffer Isenberg on 16-May-16.
*/


<script type="text/ecmascript-6">
    export default {

        methods: {

            goBack() {

                // When creating things from a screengroup, this will send user back
                if (this.$route.query.screengroup)
                    return router.go({ path:'/screengroups/'+this.$route.query.screengroup });
                
                // Check if there is any previous location
                if (this.$root && this.$root.history && this.$root.history.previous){

                    let prev = this.$root.history.previous.split('.')
                    
                    // When user created things and is editing, go back to index
                    if (prev[1] == 'create')
                        return router.go({ name: prev[0] + '.index' });

                    // When editing things that belongs to another object, go back to that object
                    if (this.$root.history.params)
                        return router.go({ name: this.$root.history.previous, params: this.$root.history.params });

                    // Else, just go back
                    return router.go({ name: this.$root.history.previous });

                }

                // No matches, just go up
                this.goUp();

            },

            goUp() {

                if (this.$route.path){

                    let path = this.$root.$route.path.split('/');
                    router.go({ name: path[1] + '.index' });

                }
                
            }

        }

    }
</script>