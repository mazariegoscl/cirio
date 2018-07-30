<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Document</title>
      <link href="assets/css/dropzone.css" rel="stylesheet" />
      <script src="assets/js/jquery.js"></script>
      <script src="assets/js/dropzone.js"></script>
      <script>
      Dropzone.options.myAwesomeDropzonee = {
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: 5,
            addRemoveLinks: false,
            dictResponseError: 'Server not Configured',
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
            init:function(){
                  var self = this;

                  document.querySelector("#finish_documents").addEventListener("click", function() {
                        self.processQueue(); // Tell Dropzone to process all queued files.
                  });
                  // config
                  self.options.addRemoveLinks = true;
                  self.options.dictRemoveFile = "Delete";
                  var counter_files = self.files.length;
                  //New file added
                  self.on("addedfile", function (file) {
                        console.log('new file added ', file);
                  });
                  // Send file starts
                  self.on("sending", function (file) {
                        console.log('upload started', file);
                        $('.meter').show();
                  });

                  // File upload Progress
                  self.on("totaluploadprogress", function (progress) {
                        console.log("progress ", progress);
                        $('.roller').width(progress + '%');
                  });

                  self.on("queuecomplete", function (progress) {
                        //$('.meter').delay(999).slideUp(999);
                        console.log("SUBIDO");
                        console.log(self.files.length);
                  });

            }
      };
      </script>
</head>
<body>
      <form method="post" class="dropzone" id="my-awesome-dropzonee" action="index.php?mode=page&controller=PageController&action=testUpload">
            <div class="dz-message" data-dz-message><span>Presione / Arrastre sus archivos aquí</span></div>
      </form>

      <button id="finish_documents">Subir</button>
</body>
</html>
