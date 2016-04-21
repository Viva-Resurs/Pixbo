<!-- DataTables -->
<script type="text/javascript" src="/js/vendor/dataTables/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/vendor/jquery.dataTables.min.css">
<script>
// Settings
var datatables_settings = {
	"language": {
		"url": "/js/vendor/dataTables/{{session('locale')}}.json",
	}
};
// Function to attach DataTable on given tables
function datatables_attach (table_id_list_string) {
    if (!table_id_list_string) return false;
    var table_id_list = table_id_list_string.split(',');
	if (!table_id_list) return false; // No IDs
    for (var i=0 ; i<table_id_list.length ; i++){
        $('#'+table_id_list[i]).DataTable(datatables_settings); // Attach DataTable
    }
}
// Attach these tables when page is ready:
$(document).ready(function() { datatables_attach('{{ $table_id_list_string }}'); });
</script>