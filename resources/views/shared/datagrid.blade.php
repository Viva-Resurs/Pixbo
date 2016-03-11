<script type="text/javascript">
    $(document).ready(function() {
        $('#{{ $table_id }}').DataTable({
            "language": {
                "url": "/js/vendor/dataTables/{{session('locale')}}.json",
            }
        });
} );
</script>