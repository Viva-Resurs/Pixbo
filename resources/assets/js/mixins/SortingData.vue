<script type="text/ecmascript-6">
/*
 * @author ToxicTree
 */
    export default {

        methods: {

            // Sort objects by targeting a deeper property
            deepSort(a, b) {
                
                var checkA = a;
                var checkB = b;

                // Dig down to the properties to compare
                var level = this.order.split('.');

                for (var i=0; i<level.length ; i++){
                    if (!checkA[level[i]] || !checkB[level[i]])
                        return 0;
                    checkA = checkA[level[i]];
                    checkB = checkB[level[i]];
                }

                // Compare numbers
                if (typeof checkA == 'number'){
                    if (checkA == checkB)
                        return 0;
                    return (checkA - checkB) * this.desc;
                }

                // Compare strings
                if (typeof checkA == 'string'){
                    checkA = checkA.toLowerCase();
                    checkB = checkB.toLowerCase();

                    // Char by char
                    for (var i=0 ; i<checkA.length ; i++){
                        if (checkA[i] < checkB[i])
                            return -1 * this.desc;
                        if (checkA[i] > checkB[i])
                            return 1 * this.desc;
                    }
                    return 0;
                }

                // Compare array lengths
                if (typeof checkA == 'object'){
                    if (checkA.length == checkB.length)
                        return 0;
                    return (checkA.length - checkB.length) * this.desc;
                }
            },

            // Set order & toggle desc
            setOrder(what,desc){
                this.desc = (this.order == what) ? this.desc*=-1 : (desc) ? -1 : 1;
                this.order = what || event.updated_at;
            },

        }

    }
</script>
