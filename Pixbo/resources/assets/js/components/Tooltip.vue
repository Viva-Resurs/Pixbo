<script>
    export default {
        methods: {
            Tooltip_attach : function(elements){
                if (!elements) return false;
                for (var i=0 ; i<elements.length ; i++){
                    $(elements[i]).tooltip(); // Attach Tooltip
                }
            },
        },
        ready: function(){
            // Get all tooltip-elements in the current schedule-form and pass them to attach-function
            this.Tooltip_attach(  $(this.$parent.$el).find('[data-toggle="tooltip"]') );
        },
    };
</script>