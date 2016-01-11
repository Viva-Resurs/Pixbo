<script>
    export default {

        template: '#screen-template',
        props: ['id'],

        data: function() {
            return {
                screengroups: [],
                screen: '',
                event: '',
                selected_screengroups: [],
                selected_tags: '',
                tags: [],
                day_num: [],
            };
        },

        methods: {
            update_tags: function() {

            },
            send_post: function() {
                var raw_data = {event: this.event, selected_screengroups: this.selected_screengroups, selected_tags: this.selected_tags, day_num: this.day_num};
                this.$http.post('/api/screen/' + this.screen.id, raw_data);
            }
        },

        computed: {
            summary: function() {
                return 'summary_text';
            },
            tagged: function() {
                var tag_string = '';
                for (var i =0;i<this.tags.length;i++) {
                    tag_string += this.tags[i].name;
                    if(i != this.tags.length -1)
                        tag_string += ' ';
                }
                return tag_string;
            },
        },
         ready: function () {
            this.$http.get('/api/screengroups', function(screengroups) {
                this.screengroups = screengroups;
            }.bind(this));
            this.$http.get('/api/tags', function(tags) {
                this.tags = tags;
            }.bind(this));
            this.$http.get('/api/screen/' + this.id, function(screen) {
                this.screen = screen;
                this.event = screen.event.pop();
                this.tags = screen.tags;
                for (var i =0;i<screen.screengroups.length;i++) {
                    this.selected_screengroups.push(screen.screengroups[i].id);
                }
            }.bind(this));
        },
    };
</script>

<style>

</style>