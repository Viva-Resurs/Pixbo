<!-- DateTimePicker -->
<script type="text/javascript" src="/js/vendor/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/js/vendor/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/vendor/bootstrap-datetimepicker.min.css">
<script>
// Settings
var datetimepicker_settings = {
	locale: 'sv',
	sideBySide: true,
	showTodayButton: true,
};
// Load Lang-into Tooltips
$.ajax({
    url: '/js/vendor/datetimepicker/{{session('locale')}}.json',
    success: function (data) {
       	datetimepicker_settings.tooltips = JSON.parse(data);
    }
});
// Function to attach DateTimePicker on given elements
function datetimepicker_attach (elements) {
    if (!elements) return false;
    for (var i=0 ; i<elements.length ; i++){
        $(elements[i]).datetimepicker(datetimepicker_settings); // Attach DateTimePicker
    }
}
// Attach to these elements when page is ready:
$(document).ready(function() { 
	datetimepicker_attach( $('.input-group.date') );
});
</script>