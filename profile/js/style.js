function uploadIcon() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = e => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = event => {
                const icon = document.getElementById('profileIcon');
                icon.src = event.target.result;
                icon.style.display = 'block'; // アイコンを表示
                icon.parentElement.style.backgroundColor = 'transparent'; // 背景を透明に
            };
            reader.readAsDataURL(file);
        }
    };
    input.click();
}

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

// 以下のように呼び出しを修正
Change('iconInput', 'profileIcon');
Change('subImageInput1', 'subImage1');
Change('subImageInput2', 'subImage2');
Change('subImageInput3', 'subImage3');


/* サブウィンドウの表示と非表示 */
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
