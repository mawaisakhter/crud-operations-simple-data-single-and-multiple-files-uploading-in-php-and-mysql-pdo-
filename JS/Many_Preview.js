document.getElementById('product_images').addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
      const previewContainer = document.getElementById('image-preview-container');
      previewContainer.innerHTML = '';

      const files = event.target.files;

      for (const file of files) {
        const reader = new FileReader();

        reader.onload = function (e) {
          const imagePreview = document.createElement('div');
          imagePreview.classList.add('col-md-3');

          const image = document.createElement('img');
          image.src = e.target.result;
          image.classList.add('img-fluid'); // Bootstrap class for responsive images

          imagePreview.appendChild(image);
          previewContainer.appendChild(imagePreview);
        };

        reader.readAsDataURL(file);
      }
    }