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

                // Check Arguments
                if (checkA==undefined || checkB==undefined)
                    return 0;

                // Not the same type?
                if (typeof checkA != typeof checkB)
                    return 0;

                // Dig down to the properties to compare
                var level = this.order.split('.');

                for (var i=0; i<level.length ; i++){
                    if (checkA[level[i]]==undefined || checkB[level[i]]==undefined)
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

                // Compare arrays
                if (typeof checkA == 'object'){
                    
                    // Compare lengths
                    if (checkA.length != checkB.length)
                        return (checkA.length - checkB.length) * this.desc;

                    // Compare contents (.name)
                    for (var i=0 ; i<checkA.length ; i++){
                        // Nothing to compare
                        if (!checkA[i].name && !checkB[i].name)
                            return 0;

                        // Equal
                        if (checkA[i].name == checkB[i].name)
                            return 0;

                        // Char by char
                        for (var c=0 ; c<checkA[i].name.length ; c++){
                            if (checkA[i].name[c] < checkB[i].name[c])
                                return -1 * this.desc;
                            if (checkA[i].name[c] > checkB[i].name[c])
                                return 1 * this.desc;
                        }

                        return 0;

                    }

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
