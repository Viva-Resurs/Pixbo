<script type="text/ecmascript-6">
    import langList from '../lang/'

    export default {

        data: function(){
            return {
                langList: langList,
                lang: langList.sv,
                langChoise: false,
                defaultLang: 'sv'
            }
        },

        methods: {

            trans(string, num) {

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
            }

        },

        created: function(){
            var l = localStorage.getItem('lang');
            if (l)
                this.langChoise = l;
            else
                localStorage.setItem('lang', this.defaultLang);
            this.lang = this.langList[l];
        },

        watch: {
            // When lang changes
            langChoise: function(val, oldVal){

                localStorage.setItem('lang', val);

                this.lang = this.langList[val];

                if (oldVal != false)
                    location.reload();
            }
        }

    }
</script>
