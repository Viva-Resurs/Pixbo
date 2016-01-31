<script type="text/javascript">
    $(document).ready(function() {
        var lang = $('html').attr('lang');
        $('#{{ $table_id }}').DataTable({
            "language": {
                "url": "/js/vendor/dataTables/" + lang + ".json",
            }
        });
} );
</script>