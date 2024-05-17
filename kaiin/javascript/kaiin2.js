
// ファイル入力要素を取得
const fileInput = document.getElementById('fileInput');

// 画像表示要素を取得
const imageDisplay = document.getElementById('imageDisplay');

// ファイル入力の変更イベントを監視
fileInput.addEventListener('change', (event) => {
    // ファイルリストを取得
    const files = event.target.files;
    
    // ファイルが選択されている場合
    if (files && files[0]) {
        // FileReaderを使用して画像を読み込む
        const reader = new FileReader();
        
        reader.onload = (e) => {
            // 画像のsrc属性を設定
            imageDisplay.src = e.target.result;
            // 画像要素を表示
            imageDisplay.style.display = 'block';
        };
        
        // 画像ファイルをData URLとして読み込む
        reader.readAsDataURL(files[0]);
    }
});
