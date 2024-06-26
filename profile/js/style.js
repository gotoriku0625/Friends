// function uploadIcon() {
//     const input = document.createElement('input');
//     input.type = 'file';
//     input.accept = 'image/*';
//     input.onchange = e => {
//         const file = e.target.files[0];
//         if (file) {
//             const reader = new FileReader();
//             reader.onload = event => {
//                 const icon = document.getElementById('profileIcon');
//                 icon.src = event.target.result;
//                 icon.style.display = 'block'; // アイコンを表示
//                 icon.parentElement.style.backgroundColor = 'transparent'; // 背景を透明に
//             };
//             reader.readAsDataURL(file);
//         }
//     };
//     input.click();
// }

function uploadSubImage(inputId, imageId) {
    const fileInput = document.getElementById(inputId);
    fileInput.click();
    fileInput.addEventListener('change', function(event) {
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

function openSubWindow() {
    document.querySelector('.bg_sub_window').style.visibility = 'visible';
    document.querySelector('.bg_sub_window').style.opacity = '1';
    document.querySelector('.bg_sub_window').style.pointerEvents = 'auto';
}

function closeSubWindow() {
    document.querySelector('.bg_sub_window').style.visibility = 'hidden';
    document.querySelector('.bg_sub_window').style.opacity = '0';
    document.querySelector('.bg_sub_window').style.pointerEvents = 'none';
}

function setupImagePreview(inputId, imageId) {
    document.getElementById(inputId).addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function () {
                const display = document.getElementById(imageId);
                display.src = reader.result;
                display.style.display = 'block'; // 画像を表示
            }, false);
            reader.readAsDataURL(file);
        }
    });
}

setupImagePreview('iconInput', 'profileIcon');
setupImagePreview('subImageInput1', 'subImage1');
setupImagePreview('subImageInput2', 'subImage2');
setupImagePreview('subImageInput3', 'subImage3');
