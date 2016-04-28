<!-- Tooltip -->
<script>
function tooltip_attach(elements){
	if (!elements) return false;
	for (var i=0 ; i<elements.length ; i++){
		$(elements[i]).tooltip(); // Attach Tooltip
	}
}
// Attach tooltip to elements when page is ready:
$(document).ready(function() { tooltip_attach( $('[data-toggle="tooltip"]') ); });
</script>