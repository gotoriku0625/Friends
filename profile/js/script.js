function Change(inputId, imageId) {
    document.getElementById(inputId).addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const image = document.getElementById(imageId);
                image.src = e.target.result;
                image.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
}
Change('imageInput','selectedImage');
Change('subImageInput1', 'subImage1');
Change('subImageInput2', 'subImage2');
Change('subImageInput3', 'subImage3');
