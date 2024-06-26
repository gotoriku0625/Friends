<?php require '../header.php';?>
<?php require '../menu/menu.php';?><!--menuはbodyタグの中に絶対に入れるように -->
    <link rel="stylesheet" href="css/profile.css">
<title>プロフィール</title>
</head>
<body>
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.html"><img src="../image/logo.png" class="logo"></a>
        </div>
        <div class="icon"></div>
        <!-- バックエンドの方、ユーザーネームの出力お願いします -->
        <div class="name">ユーザー名</div>
        <div class="link-space">
            <p><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.html">プロフィール</a></p>
            <p><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../search/search.php">さがす</a></p>
            <p><img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../likes/ilike.php">いいね</a></p>
            <p><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">コミュニティ</a></p>
            <p><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk2.php">トーク</a></p>
        </div>
    </div>
    <!-- ここからプロフィールのプログラム -->
    <div class="main">
        <div class="title">
            <p class="title">プロフィール</p> 
            <a href="/logout.html">ログアウト</a>
        </div>
        <hr>
        <div class="container">
            <div class="circle-wrapper">
                <div class="circle" id="imageContainer">
                    <img id="selectedImage" alt="選択された画像">
                </div>
                <label for="imageInput" id="imagePut">+</label> <!-- ファイル選択の代わりに「＋」を表示 -->
                <input type="file" id="imageInput" accept="image/*" style="display: none;"> <!-- ファイル選択ボタンは非表示にする -->
            </div>
        </div>
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
        <p>ユーザー名</p>
        <!--ユーザー名の出力PHP-->
        <p>自己紹介</p>
        <textarea id="message" name="message" rows="4" cols="500" class="introduction"></textarea>
        <p>趣味/特技</p>
        <textarea id="message" name="message" rows="4" cols="500" class="Hobby"></textarea>
        <p>性別</p>
        <select id="sex" name="sex">
            <option value="man">男</option>
            <option value="woman">女</option>
            <option value="another">その他</option>
        </select>
        <p>年齢</p>
        <input type="text" class="age">
        <p>血液型</p>
        <select id="blood" name="blood" class="blood-type">
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="o">O</option>
            <option value="ab">AB</option>
        </select>
        <p>学校</p>
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
        <p>出身地</p>
        <select id="hometown">
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
        <p>居住地</p>
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
        <p>休日の過ごし方</p>
        <textarea id="message" name="message" rows="4" cols="500" class="off"></textarea>
        <label for="option1"><input type="checkbox" id="option1" name="options" value="Option 1">飲酒</label>
        <label for="option2"><input type="checkbox" id="option2" name="options" value="Option 2">喫煙</label>        
        <br>
        <div class="btn-container">
            <a href="../login/login.html" class="btn">キャンセル</a>
            <a href="../top/top.html" class="btn">保存</a>
        </div>
    </div>
    <script src="js/style.js"></script>
</body>
</html>