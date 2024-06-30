document.getElementById('fileToUpload').addEventListener('change', function (event) {
    var preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
});