<script>
    import Tags from './Tags.vue';

    export default {


        template: '#schedule-template',
        props: ['id', 'model'],

        components: {

            'Tagger': Tags,

        },

        data: function() {
            return {
                screengroups: [],
                modelObject: {},
                event: {},
                selected_screengroups: [],
                selected_tags: '',
                tags: [],
                weekly_day_num: [],
                monthly_day_num: '',
            };
        },

        methods: {
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
                    modelObject: this.modelObject,
                };
                this.send_ajax(payload);

            },

            send_ajax: function(payload) {
                var vm = this;
                console.log(vm.modelObject);
                this.$http.put('/admin/' + vm.model + '/' + vm.modelObject.id, payload).then(function (response) {
                    if(response.ok) {
                        vm.close_modal();
                    }
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
            get_model: function() {
                this.$http.get('/api/' + this.model + '/' + this.id, function(modelObject) {
                    this.modelObject = modelObject;
                    if (modelObject.event)
                      this.event = modelObject.event.pop();
                    if(this.model == 'screens')
                        this.selected_tags = modelObject.tags;
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
                    if(typeof parsed_week == 'string' || parsed_week == null)
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
                var sgs = this.modelObject.screengroups != null ? this.modelObject.screengroups.length : 0;
                for (var i =0;i<sgs;i++) {
                    this.selected_screengroups.push(this.modelObject.screengroups[i].id);
                }
            },

            close_modal: function() {
                var modal = '#' + this.model + '_modal_' + this.modelObject.id;
                console.log(modal);
                $(modal).modal('hide');
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
            if(this.model == 'screens')
                this.get_all_tags();
            this.get_model();
        },
    };
</script>

<style>

</style>