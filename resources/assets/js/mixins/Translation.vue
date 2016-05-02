<script>
    export default {
        data: function(){
            return {
                lang: this.$root.$data.lang,
                loaded: this.$root.$data.loaded,
                modules: [
                    'general',
                    'ticker',
                    'screen',
                    'screengroup',
                    'datetimepicker_tooltip',
                ],
            }
        },
        methods: {
            init: function (){
                var self = this;
                self.$root.$data.lang=[];
                for (var i=0 ; i<self.modules.length ; i++){
                    $.ajax({
                        url: '/lang/'+self.modules[i]+'.sv.lang',
                        indexValue: i,
                        success: function(result){
                            try {
                                self.$root.$data.lang[self.modules[this.indexValue]] = JSON.parse(result);
                            } catch (err) {
                                console.log(err);
                            }
                        }
                    });
                }
                self.$root.$data.loaded = true;
            },
            trans: function (string) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];

                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    return this.lang[scope][word];
                else
                    return string; // Fallback
            },
            trans_choice: function(string, num) {
                var scope = string.split('.')[0];
                var word = string.split('.')[1];
                
                if (this.lang && this.lang[scope] && this.lang[scope][word])
                    return this.lang[scope][word].split('|')[num-1];
                else
                    return string; // Fallback
            },
        },
        created: function(){
            if (!this.$root.$data.loaded)
                this.init();
        },
    };
</script>