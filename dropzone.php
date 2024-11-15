<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <title>File Upload with Dropzone</title>
    <style>
        .dz-preview .dz-details {
            position: relative;
        }
        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>File Upload with Dropzone</h1>
    <form action="upload.php" class="dropzone" id="myDropzone"></form>
    
    <script>
        // Initialize Dropzone
        Dropzone.options.myDropzone = {
            maxFilesize: 2, // MB
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            init: function() {
                this.on("success", function(file, response) {
                    console.log(response);
                    loadFiles(); // Reload files after upload
                });
                
                loadFiles(); // Load existing files on init
            }
        };

        // Load existing files into Dropzone
        function loadFiles() {
            fetch('fetch_files.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(file => {
                        addFileToDropzone(file.filename, file.id);
                    });
                });
        }

        // Add existing file to Dropzone
        function addFileToDropzone(filename, id) {
            const mockFile = { name: filename, size: 1234 }; // Mock file object
            const dz = Dropzone.forElement("#myDropzone");
            dz.emit("addedfile", mockFile);
            dz.emit("thumbnail", mockFile, `uploads/${filename}`);
            dz.emit("complete", mockFile);

            // Create a delete button
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Delete";
            deleteButton.classList.add("delete-btn");
            deleteButton.onclick = () => deleteFile(id, mockFile);

            mockFile.previewElement.appendChild(deleteButton);
        }

        // Delete file
        function deleteFile(id, mockFile) {
            fetch('delete_file.php?id=' + id, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const dz = Dropzone.forElement("#myDropzone");
                    dz.removeFile(mockFile); // Remove from Dropzone
                    loadFiles(); // Reload files after deletion
                });
        }
    </script>
</body>
</html>
