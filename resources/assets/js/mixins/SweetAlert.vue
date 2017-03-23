<script type="text/ecmascript-6">
    import swal from 'sweetalert'

    export default {
        methods: {
            confirm(what) {
                swal({
                    title: what.title || this.trans('confirm.title'),
                    text: what.text || this.trans('confirm.text'),
                    type: what.type || "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: what.confirmButtonText || this.trans('confirm.confirmButtonText'),
                    cancelButtonText: this.trans('confirm.cancelButtonText'),
                    closeOnConfirm: true
                },function(){
                    what.callback(what.arg)
                });
            }
        }
    };
</script>
