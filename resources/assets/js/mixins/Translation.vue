<script>
    import lang from '../lang/sv'
    export default {
        data: function(){
            return {
                lang: lang
            }
        },
        methods: {
            trans: function(string, num) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];
                
                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    if (num!=1)
                        return (this.lang[scope][word].split('|').length>1) ? this.lang[scope][word].split('|')[1] : this.lang[scope][word];
                    else
                        return this.lang[scope][word].split('|')[0];
                else {
                    console.log("Add lang for: " + string);
                    return string; // Fallback
                }
            },
        },
    };
</script>