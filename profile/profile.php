<?php require '../header.php';?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require '../menu/menu.php';?><!--menuはbodyタグの中に絶対に入れるように -->
    <title>プロフィール</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <p>プロフィール</p>
        <hr>
        <div class="icon-section">
            <span>アイコンの変更</span>
            <div class="icon-container">
                <img id="profileIcon" src="placeholder.png" alt="プロフィールアイコン">
                <span class="plus" onclick="uploadIcon()">＋</span>
            </div>
        </div>

        <div class="sub-photo-section">
            <span>サブ写真</span>
            <div class="sub-photos">
                <div class="sub-photo-container">
                    <img id="subPhoto1" src="placeholder.png" alt="サブ写真1">
                </div>
                <div class="sub-photo-container">
                    <img id="subPhoto2" src="placeholder.png" alt="サブ写真2">
                </div>
                <div class="sub-photo-container">
                    <img id="subPhoto3" src="placeholder.png" alt="サブ写真3">
                </div>
                <span class="plus" onclick="uploadSubPhotos()">＋</span>
            </div>
        </div>

        <!-- その他のフォーム要素 -->
        <form>
            <div class="form-group">
                <label for="username">ユーザー名</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="selfIntro">自己紹介</label>
                <textarea id="selfIntro" name="selfIntro" rows="5" maxlength="500"></textarea>
            </div>
            <div class="form-group">
                <label for="hobbies">趣味/特技</label>
                <input type="text" id="hobbies" name="hobbies">
            </div>
            <div class="form-group">
                <label for="gender">性別</label>
                <select id="gender" name="gender">
                    <option value="male">男</option>
                    <option value="female">女</option>
                </select>
            </div>
            <div class="form-group">
                <label for="age">年齢</label>
                <input type="number" id="age" name="age" min="0">
            </div>
            <div class="form-group">
                <label for="bloodType">血液型</label>
                <select id="bloodType" name="bloodType">
                    <option value="A">A型</option>
                    <option value="B">B型</option>
                    <option value="O">O型</option>
                    <option value="AB">AB型</option>
                </select>
            </div>
            <div class="form-group">
            <select id="school" name="school">
                <option value="麻生情報ビジネス専門学校 福岡校">麻生情報ビジネス専門学校 福岡校</option>
                <option value="麻生外語観光＆ブライダル専門学校">麻生外語観光＆ブライダル専門学校</option>
                <option value="麻生医療福祉＆保育専門学校 福岡校">麻生医療福祉＆保育専門学校 福岡校</option>
                <option value="麻生建築＆デザイン専門学校">麻生建築＆デザイン専門学校</option>
                <option value="麻生公務員専門学校 福岡校">麻生公務員専門学校 福岡校</option>
                <option value="ASOポップカルチャー専門学校">ASOポップカルチャー専門学校</option>
                <option value="麻生美容専門学校 福岡校">麻生美容専門学校 福岡校</option>
                <option value="専門学校 麻生リハビリテーション大学">専門学校 麻生リハビリテーション大学</option>
                <option value="専門学校 麻生工科自動車大学校">専門学校 麻生工科自動車大学校</option>
                <option value="麻生情報ビジネス専門学校 北九州校">麻生情報ビジネス専門学校 北九州校</option>
                <option value="麻生公務員専門学校 北九州校">麻生公務員専門学校 北九州校</option>
                <option value="専門学校 麻生看護大学校">専門学校 麻生看護大学校</option>
                <option value="麻生公務員専門学校 福岡校">麻生公務員専門学校 福岡校</option>
                <option value="ASO高等部">ASO高等部</option>            
            </select>
            </div>
            <div class="form-group">
                <label for="hometown">出身地</label>
                <select id="hometown" name="hometown">
                    <option value="tokyo">東京</option>
                    <option value="osaka">大阪</option>
                    <option value="kyoto">京都</option>
                </select>
            </div>
            <div class="form-group">
                <label for="residence">居住地</label>
                <input type="text" id="residence" name="residence">
            </div>
            <div class="form-group">
                <label for="spendHoliday">休日の過ごし方</label>
                <input type="text" id="spendHoliday" name="spendHoliday">
            </div>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="drinking" value="drinking"> 飲酒
                </label>
                <label>
                    <input type="checkbox" name="smoking" value="smoking"> 喫煙
                </label>
            </div>
            <div class="form-group" id="submit_button">
                <button type="submit">保存</button>
                <button type="button" onclick="cancel()">キャンセル</button>
            </div>
        </form>
    </div>

    <script>
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
    </script>
</body>
</html>