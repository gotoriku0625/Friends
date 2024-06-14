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

function uploadSubPhotos() {
    const inputs = [];
    for (let i = 1; i <= 3; i++) {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        inputs.push(input);
    }

    inputs.forEach((input, index) => {
        input.onchange = e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = event => {
                    const subPhoto = document.getElementById(`subPhoto${index + 1}`);
                    subPhoto.src = event.target.result;
                    subPhoto.style.display = 'block'; // サブ写真を表示
                    subPhoto.parentElement.style.backgroundColor = 'transparent'; // 背景を透明に
                };
                reader.readAsDataURL(file);
            }
        };
        input.click();
    });
}

function cancel() {
    // キャンセルボタンの処理
}

/*サブウィンドウｊｓ*/ 

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