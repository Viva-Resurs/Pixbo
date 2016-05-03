<script>

    export default {
        data: function(){
            return {
                lang: window.lang
            }
        },
        methods: {
            trans: function (string) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];

                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    return this.lang[scope][word];
                else {
                    console.log('MISSING LANG for: ' + string)
                    console.log(scope)
                    return string; // Fallback
                }

            },
            trans_choice: function(string, num) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];
                
                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    return this.lang[scope][word].split('|')[num-1];
                else {
                    console.log("MISSING LANG for: " + string);
                    console.log(scope)
                    return string; // Fallback
                }

            },
        },
        created() {
            if(localStorage.lang)
                this.lang = JSON.parse(localStorage.getItem('lang'));
        }
    };
</script>