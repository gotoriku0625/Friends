document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const imageDisplay = document.getElementById('imageDisplay');
    const placeholderText = document.querySelector('.placeholder-text');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imageDisplay.src = e.target.result;
                placeholderText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    const imageContainer = document.querySelector('.image-container');
    imageContainer.addEventListener('click', function() {
        fileInput.click();
    });
});
