document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const image = document.getElementById('selectedImage');
            image.src = e.target.result;
            image.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('subImageInput1').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const image = document.getElementById('subImage1');
            image.src = e.target.result;
            image.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('subImageInput2').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const image = document.getElementById('subImage2');
            image.src = e.target.result;
            image.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('subImageInput3').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const image = document.getElementById('subImage3');
            image.src = e.target.result;
            image.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

