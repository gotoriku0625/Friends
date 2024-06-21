<!-- プロフィールを更新するためのもの -->
<?php require '../header.php';?>
<?php require '../menu/menu.php';?><!--menuはbodyタグの中に絶対に入れるように -->
<title>プロフィール</title>
<link rel="stylesheet" href="css/profile.css">
<script src="js/style.js"></script>
</head>
<body>
<?php
$pdo=new PDO($connect,USER,PASS);
$select='select * from user,profile where user.user_id = profile.user_id user_id=?';
$sql=$pdo->prepare($select);
?>
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
        <?php 
        if(isset($_SESSION['user']['id'])){
            $sql->execute($_SESSION['user']['id']);
            //明日はここから
            foreach($sql->fetch() as $user){
                echo <<< EOF
                <!-- その他のフォーム要素 -->
                <form action="./profile-upout.php" method="post">
                <div class="icon-section">
                    <span>アイコンの変更</span>
                    <div class="icon-container">
                        <img id="profileIcon" src="../user_image/main/{$user['icon_image']}" alt="プロフィールアイコン" name="profileIcon" value="main">
                        <span class="plus" onclick="uploadIcon()">＋</span>
                    </div>
                </div>

                <!-- <div class="sub-photo-section">
                    <span>サブ写真</span>
                    <div class="sub-photos">
                        <div class="sub-photo-container">
                            <img id="subPhoto1" src=alt="サブ写真1" name="subPhoto1" >
                        </div>
                        <div class="sub-photo-container">
                            <img id="subPhoto2" src="placeholder.png" alt="サブ写真2" name="subPhoto2">
                        </div>
                        <div class="sub-photo-container">
                            <img id="subPhoto3" src="placeholder.png" alt="サブ写真3" name="subPhoto3">
                        </div>
                        <span class="plus" onclick="uploadSubPhotos()">＋</span>
                    </div>
                </div> -->

                <p>サブ写真</p>
                <div class="sub-images">
                    <div class="sub-image-wrapper">
                        <div class="sub-square" id="subImageContainer1">
                            <img id="subImage1" src="../user_image/sub/{$user['sub_a_image']}"  alt="サブ写真1">
                        </div>
                        <label for="subImageInput1" class="subImagePut">+</label>
                        <input type="file" id="subImageInput1" name="subImage1" accept="image/*" style="display: none;">
                    </div>
                    <div class="sub-image-wrapper">
                        <div class="sub-square" id="subImageContainer2">
                            <img id="subImage2" src="../user_image/sub/{$user['sub_b_image']}" alt="サブ写真2">
                        </div>
                        <label for="subImageInput2" class="subImagePut">+</label>
                        <input type="file" id="subImageInput2" name="subImage2" accept="image/*" style="display: none;">
                    </div>
                    <div class="sub-image-wrapper">
                        <div class="sub-square" id="subImageContainer3">
                            <img id="subImage3" src="../user_image/sub/{$user['sub_c_image']}" alt="サブ写真3">
                        </div>
                        <label for="subImageInput3" class="subImagePut">+</label>
                        <input type="file" id="subImageInput3" name="subImage3" accept="image/*" style="display: none;">
                    </div>
                </div>

                
                    <div class="form-group">
                        <label for="username">ユーザー名</label>
                        <input type="text" id="username" name="username" value="{$user['user_name']}">
                    </div>
                    <div class="form-group">
                        <label for="selfIntro">自己紹介</label>
                        <textarea id="selfIntro" name="selfIntro" value="{$user['user_info']}" rows="5" maxlength="500" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hobbies">趣味/特技</label>
                        <select name="category">
                        \n
                        EOF;
                        $hobby=$user['hobby_id'];
                        foreach($pdo->query('select * from hobby order by sports_id') as $row){
                            if($hobby==$row['sports_id']){
                                echo '<option value=',$hobby,' selected>',$row['hobby_name'],'</option>';
                            }else{
                                echo '<option value=',$row['hobby_id'],'>',$row['hobby_name'],'</option>';
                            }
                        }
                    
                        //  <input type="text" id="hobbies" name="hobbies" required>
                    echo '</div>';
                    $gender=$user['gender_id'];
                    echo '<div class="select-group">';
                        echo '<label for="gender">性別</label>';
                        echo '<select id="gender" name="gender"required>';
                        foreach($pdo->query('select * from gender order by gender_id') as $row){
                            if($gender==$row['gender_id']){
                                echo '<option value=',$gender,' selected>',$row['gender_name'],'</option>';
                            }else{
                                echo '<option value=',$row['gender_id'],'>',$row['gender_name'],'</option>';
                            }
                        }
                        echo '</select>';
                    echo '</div>';
                    echo<<<EOF
                    <div class="select-group">
                        <label for="age">年齢</label>
                        <input type="number" id="age" name="age" value="{$user['age']}" min="0" required>
                    </div>
                    <div class="select-group">
                        <label for="bloodType">血液型</label>
                        <select id="bloodType" name="bloodType">
                    \n
                    EOF;
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
                        <textarea id="message" name="message" value="{$user['holiday_spend']}" rows="4" cols="500" class="off"></textarea>
                    </div>
            \n
            EOF;
                    echo '<div class="checkbox-group">';
                        echo  '<label>';
                        if($user['alcohol']==1){
                            echo '<input type="hidden" name="drinking" value="0">';
                            echo '<input type="checkbox" name="drinking" value="1" checked>飲酒';
                        }else{
                            echo '<input type="hidden" name="drinking" value="0">';
                            echo '<input type="checkbox" name="drinking" value="1">飲酒';
                        }
                        echo '</label>';
                        echo '<label>';
                        if($user['smoke']==1){
                            echo '<input type="hidden" name="smoking" value="0">';
                            echo '<input type="checkbox" name="smoking" value="1" checked> 喫煙';
                        }else{
                            echo '<input type="hidden" name="smoking" value="0">';
                            echo '<input type="checkbox" name="smoking" value="1">喫煙';
                        }  
                        echo '</label>';
                    echo '</div>';
        
            }
        }
        ?>
            <div class="form-group" id="submit_button">
                <div class="btn-container">
                    <a href="../login/login.html" class="btn">キャンセル</a>
                    <a href="../top/top.html" class="btn">保存</a>
                </div>
            </div>

        </form>
    </div>
</body>
</html>