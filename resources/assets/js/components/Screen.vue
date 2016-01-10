<script>
    export default {

        template: '#screen-template',
        props: ['id'],

        data: function() {
            return {  
                screengroups: [],
                tags: [],
                event: '',
                messages: [],
                recur_type: [],
                day_num: [],
            };
        },

        methods: {
            getMessage: function(message) {
                this.$http.get('/api/lang/' + message, function(translated) {
                    this.messages.push({message: message, translated: translated}); 
                });
            },
            getTranslated: function(message) {
                
                console.log(this.messages);
                for (var msg in msgs) {
                    if(msg.message == msg) {
                        console.log(msg);
                        return msg.translated;
                    }
                }
            },
        },

        computed: {
            summary: function() {
                return 'summary_text';
            }
        },
         ready: function () {
            this.$http.get('/api/screengroups', function(screengroups) {
                this.screengroups = screengroups;
            }.bind(this));
            this.$http.get('/api/tags', function(tags) {
                this.tags = tags;
            }.bind(this));
            this.$http.get('/api/event/screen/' + this.id, function(event) {
                this.event = event.pop();
            }.bind(this));
        },
    };
</script>

<style>
    
</style>