<script>
    import swal from 'sweetalert'

    export default {
        methods: {
            confirm: function (what){
                var self = this;
                swal({
                    title: self.trans('confirm.title'),
                    text: self.trans('confirm.text'),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: self.trans('confirm.confirmButtonText'),
                    cancelButtonText: self.trans('confirm.cancelButtonText'),
                    closeOnConfirm: true
                }, function(){
                    what.callback(what.arg)
                });
            }
        }
    };
</script>