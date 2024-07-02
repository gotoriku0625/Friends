// function uploadIcon() {element.style 
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


function uploadIcon(){
    const iconInput = document.getElementById("iconInput");
    iconInput.addEventListener("change", function (e) {
        const file = e.target.files[0];//複数ファイルはfiles配列をループで回す
        const reader = new FileReader();
        const icon = document.getElementById("profileIcon");
        reader.addEventListener("load", function () {
            icon.src = reader.result;
            icon.style.display = 'block'; // アイコンを表示
            icon.parentElement.style.backgroundColor = 'transparent'; // 背景を透明に
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    });
}
function uploadSubImage(inputId, imageId) {
    // const fileInput = document.getElementById(inputId);
    // fileInput.click();
    // fileInput.addEventListener('change', function(event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             const image = document.getElementById(imageId);
    //             image.src = e.target.result;
    //             image.style.display = 'block';
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });
    const fileInput = document.getElementById(inputId);
    fileInput.addEventListener("change", function (e) {
        const file = e.target.files[0];//複数ファイルはfiles配列をループで回す
        const reader = new FileReader();
        const img = document.getElementById(imageId);
        reader.addEventListener("load", function () {
            img.src = reader.result;
            img.style.display = 'block';
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    });
}

function openSubWindow() {
    document.querySelector('.bg_sub_window').style.visibility = 'visible';
    document.querySelector('.bg_sub_window').style.opacity = '1';
    document.querySelector('.bg_sub_window').style.pointerEvents = 'auto';
    document.querySelector('.bg_sub_window').style.position = 'fixed';
    document.querySelector('.bg_sub_window').style.zIndex = '5';
}

function closeSubWindow() {
    document.querySelector('.bg_sub_window').style.visibility = 'hidden';
    document.querySelector('.bg_sub_window').style.opacity = '0';
    document.querySelector('.bg_sub_window').style.pointerEvents = 'none';
}

function setupImagePreview(inputId, imageId) {
    const inputElement = document.getElementById(inputId);
    inputElement.addEventListener('change', function (e) {
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

// 初期化関数の呼び出し
setupImagePreview('subImageInput1', 'subImage1');
setupImagePreview('subImageInput2', 'subImage2');
setupImagePreview('subImageInput3', 'subImage3');

// アイコンをアップロードするためのボタンのクリックイベントを設定
// document.querySelector('.plus').addEventListener('click', function(event) {
//     document.getElementById('iconInput').click();
//     // Prevent the default behavior to avoid any unintended effects
//     event.preventDefault();
// });
