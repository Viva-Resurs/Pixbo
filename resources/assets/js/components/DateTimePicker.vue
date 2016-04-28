<script>
    export default {
        methods: {
            DateTimePicker_attach : function(elements){
                if (!elements) return false;
                for (var i=0 ; i<elements.length ; i++){
                    $(elements[i]).datetimepicker(datetimepicker_settings); // Attach DateTimePicker
                }
            },
        },
        ready: function(){
            // Get all inputs handeling date in the current schedule-form and pass them to attach-function
            this.DateTimePicker_attach(  $(this.$parent.$el).find('.input-group.date') );
        },
    };
</script>