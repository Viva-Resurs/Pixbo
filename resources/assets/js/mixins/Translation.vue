<script>
    import lang from '../lang/sv'
    export default {
        data: function(){
            return {
                lang: lang
            }
        },
        methods: {
            trans: function (string) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];

                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    return this.lang[scope][word];
                else {
                    console.debug('Add lang for: ' + string)
                    return string; // Fallback
                }
            },
            trans_choice: function(string, num) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];
                
                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    return this.lang[scope][word].split('|')[num-1];
                else {
                    console.log("Add lang for: " + string);
                    return string; // Fallback
                }
            },
        },
    };
</script>