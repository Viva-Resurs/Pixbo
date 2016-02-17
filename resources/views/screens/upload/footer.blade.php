<script type="text/javascript">
  // Get the template HTML and remove it from the doument
  var previewNode = document.querySelector("#template");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/admin/screens/addphoto", // Set the url
    thumbnailWidth: null,
    thumbnailHeight: null,
    uploadMultiple: false,
    paramName: "photo",
    maxFiles: 1,
    maxFileSize: 10,
    acceptedFiles: '.jpg,.jpeg,.png,.bmp',

    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.

    init: function() {
      this.on("maxfilesexceeded", function(file) {
            this.removeAllFiles();
            this.addFile(file);
      });
    },
  });

  var upload_control = $('#upload_control');

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
    upload_control.toggle();
    //document.querySelector(".fileinput-button").setAttribute("disabled", "disabled");
  });
  myDropzone.on('canceled', function(file) {
    upload_control.toggle();
  });

  myDropzone.on('removedfile', function(file) {
    upload_control.toggle();
  });

  var type = null;

  myDropzone.on('success', function(file) {
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    console.log('file uploaded: ' + file);
  });

  myDropzone.on('complete', function(response) {
    //console.log(response);
    var screen = JSON.parse(response.xhr.response);
    console.log(screen);

    if(response.status == "success") {
        window.location = "/admin/screens/" +  screen.id;
    }
    vue_instance.addAlert(JSON.parse(response.xhr.response));

  });

  myDropzone.on('error', function(file) {
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    console.log('file uploaded failed');
  });

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
  };

  document.querySelector("#actions .cancel").onclick = function() {
    upload_control.toggle();
    myDropzone.removeAllFiles(true);

  };
</script>