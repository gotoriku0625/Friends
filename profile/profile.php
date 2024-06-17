<?php require '../header.php';?>
<?php require '../menu/menu.php';?><!--menuはbodyタグの中に絶対に入れるように -->
<title>プロフィール</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <p class="title">プロフィール</p>
    <!-- ログアウトボタン-->
    <!-- サブウィンドウを開くボタンの親要素 -->
        <div class="open_sub_window_wrapper">
            <form action="../logout/logout.php" method="post">
                <button type="button" class="open_sub_window" onclick="openSubWindow()">ログアウト</button>
            </form>
        </div>
        <!-- サブウィンドウの背景（クリックでサブウィンドウを閉じる） -->
        <div class="bg_sub_window" onclick="closeSubWindow()">
            <!-- サブウィンドウの内容 -->
            <div class="sub_window" onclick="event.stopPropagation()">
                <div class="sub_window_content">
                    <form action="../logout/logout.php" method="post">
                        <button type="submit" class="btn-logout">ログアウト</button>
                    </form>
                    <button class="btn-cancel" onclick="closeSubWindow()">キャンセル</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="icon-section">
            <span>アイコンの変更</span>
            <div class="icon-container">
                <img id="profileIcon" src="placeholder.png" alt="プロフィールアイコン">
                <span class="plus" onclick="uploadIcon()">＋</span>
            </div>
        </div>

        <!-- <div class="sub-photo-section">
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
        </div> -->

        <p>サブ写真</p>
        <div class="sub-images">
            <div class="sub-image-wrapper">
                <div class="sub-square" id="subImageContainer1">
                    <img id="subImage1" alt="サブ写真1">
                </div>
                <label for="subImageInput1" class="subImagePut">+</label>
                <input type="file" id="subImageInput1" accept="image/*" style="display: none;">
            </div>
            <div class="sub-image-wrapper">
                <div class="sub-square" id="subImageContainer2">
                    <img id="subImage2" alt="サブ写真2">
                </div>
                <label for="subImageInput2" class="subImagePut">+</label>
                <input type="file" id="subImageInput2" accept="image/*" style="display: none;">
            </div>
            <div class="sub-image-wrapper">
                <div class="sub-square" id="subImageContainer3">
                    <img id="subImage3" alt="サブ写真3">
                </div>
                <label for="subImageInput3" class="subImagePut">+</label>
                <input type="file" id="subImageInput3" accept="image/*" style="display: none;">
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
                <textarea id="selfIntro" name="selfIntro" rows="5" maxlength="500" required></textarea>
            </div>
            <div class="form-group">
                <label for="hobbies">趣味/特技</label>
                <input type="text" id="hobbies" name="hobbies" required>
            </div>
            <div class="select-group">
                <label for="gender">性別</label>
                <select id="gender" name="gender"required>
                <option value="man">男</option>
                <option value="woman">女</option>
                <option value="another">その他</option>
                </select>
            </div>
            <div class="select-group">
                <label for="age">年齢</label>
                <input type="number" id="age" name="age" min="0" required>
            </div>
            <div class="select-group">
                <label for="bloodType">血液型</label>
                <select id="bloodType" name="bloodType">
                    <option value="A">A型</option>
                    <option value="B">B型</option>
                    <option value="O">O型</option>
                    <option value="AB">AB型</option>
                </select>
            </div>
            <div class="select-group">
            <label for="school">学校</label>
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
            <div class="select-group">
                <label for="hometown">出身地</label>
                <select id="hometown" name="hometown">
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                </select>
            </div>
            <div class="select-group">
                <label for="residence">居住地</label>
                <select id="residence">
                    <option value="山口県">山口県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div class="form-group">
                <label for="spendHoliday">休日の過ごし方</label>
                <textarea id="message" name="message" rows="4" cols="500" class="off"></textarea>
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
                <div class="btn-container">
                    <a href="../login/login.html" class="btn">キャンセル</a>
                    <a href="../top/top.html" class="btn">保存</a>
                </div>
            </div>

        </form>
    </div>
    <script src="js/style.js"></script>
</body>
</html>