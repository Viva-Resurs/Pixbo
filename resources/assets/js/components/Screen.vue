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
                weekly_day_num: [],
                monthly_day_num: '',
            };
        },

        methods: {
            update_tags: function() {

            },
            send_post: function() {

                var day_num = null;
                var recur = this.event.recur_type;

                switch(recur) {
                    case "weekly":
                        day_num = this.weekly_day_num;
                        break;
                    case "monthly":
                        day_num = this.monthly_day_num;
                        break;
                    default:
                        day_num = '';
                        break;
                }

                var payload = {
                    event: this.event,
                    selected_screengroups: this.selected_screengroups,
                    selected_tags: this.selected_tags,
                    day_num: day_num,
                };
                this.send_ajax(payload);

            },

            send_ajax: function(payload) {
                var vm = this;
                this.$http.put('/admin/screens/' + this.screen.id, payload).then(function (response) {
                    if(response) {
                        vm.$dispatch('add-alert', response.data);
                    }
                });
            },

            get_all_screengroups: function() {
                this.$http.get('/api/screengroups', function(screengroups) {
                    this.screengroups = screengroups;
                }.bind(this));
            },
            get_all_tags: function() {
                this.$http.get('/api/tags', function(tags) {
                    this.tags = tags;
                }.bind(this));
            },
            get_screen: function() {
                this.$http.get('/api/screen/' + this.id, function(screen) {
                    this.screen = screen;
                    this.event = screen.event.pop();
                    this.tags = screen.tags;
                    this.parse_event();
                    this.set_selected_screengroups();
                }.bind(this));
            },

            parse_event: function() {
                if(this.event.recur_day_num == null) {
                    this.weekly_day_num = [];
                    this.monthly_day_num = '1';
                } else {
                    var parsed_week = JSON.parse(this.event.recur_day_num);
                    if(typeof parsed_week == 'string')
                        this.weekly_day_num = [];
                    else
                        this.weekly_day_num = parsed_week;
                    this.monthly_day_num = JSON.parse(this.event.recur_day_num);
                }

                if(this.event.recur_day == null)
                    this.event.recur_day = '1';

                if(this.monthly_day_num.length > 1 || this.monthly_day_num == "")
                    this.monthly_day_num = '1';


            },

            set_selected_screengroups: function() {
                var sgs = screen.screengroups != null ? screen.screengroups.length : 0;
                for (var i =0;i<sgs;i++) {
                    this.selected_screengroups.push(screen.screengroups[i].id);
                }
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
            this.get_all_screengroups();
            this.get_all_tags();
            this.get_screen();
        },
    };
</script>

<style>

</style>