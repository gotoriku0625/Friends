<?php require '../header.php';?>
<?php require '../menu/menu.php';?><!--menuはbodyタグの中に絶対に入れるように -->
<title>プロフィール</title>
<link rel="stylesheet" href="css/profile.css">
<script src="js/style.js"></script>
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
        <!-- フォーム要素 -->
        <form action="./profile-newout.php" method="post">
                <span>アイコン設定</span>
                <div class="icon-container">
                    <img id="profileIcon" src="placeholder.png" alt="プロフィールアイコン" name="profileIcon" value="main">
                    <span class="plus" onclick="uploadIcon()">＋</span>
                </div>
        </div>

        <!-- <div class="sub-photo-section">
            <span>サブ写真</span>
            <div class="sub-photos">
                <div class="sub-photo-container">
                    <img id="subPhoto1" src="placeholder.png" alt="サブ写真1" name="subPhoto1" >
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
                        <img id="subImage1"  alt="サブ写真1">
                    </div>
                    <label for="subImageInput1" class="subImagePut">+</label>
                    <input type="file" id="subImageInput1" name="subImage1" accept="image/*" style="display: none;">
                </div>
                <div class="sub-image-wrapper">
                    <div class="sub-square" id="subImageContainer2">
                        <img id="subImage2" alt="サブ写真2">
                    </div>
                    <label for="subImageInput2" class="subImagePut">+</label>
                    <input type="file" id="subImageInput2" name="subImage2" accept="image/*" style="display: none;">
                </div>
                <div class="sub-image-wrapper">
                    <div class="sub-square" id="subImageContainer3">
                        <img id="subImage3" alt="サブ写真3">
                    </div>
                    <label for="subImageInput3" class="subImagePut">+</label>
                    <input type="file" id="subImageInput3" name="subImage3" accept="image/*" style="display: none;">
                </div>
            </div>

        
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
                <?
                foreach($pdo->query('select * from blood_type order by blood_type_id') as $row){
                    echo '<option value=',$row['blood_type_id'],'>',$row['blood_type_name'],'</option>';   
                }
                ?>
                </select>
            </div>
            <div class="select-group">
                <label for="age">年齢</label>
                <input type="number" id="age" name="age" min="19" required>
            </div>
            <div class="select-group">
                <label for="bloodType">血液型</label>
                <select id="bloodType" name="bloodType">
                <?
                foreach($pdo->query('select * from blood_type order by blood_type_id') as $row){
                    echo '<option value=',$row['blood_type_id'],'>',$row['blood_type_name'],'</option>';
                }
                ?>
                </select>
            </div>
            <div class="select-group">
            <label for="school">学校</label>
            <select id="school" name="school">
            <?
            foreach($pdo->query('select * from school order by school_id') as $row){
                echo '<option value=',$row['school_id'],'>',$row['school_name'],'</option>';
            }
            ?>            
            </select>
            </div>
            <div class="select-group">
                <label for="hometown">出身地</label>
                <select id="hometown" name="hometown">
                <?
                foreach($pdo->query('select * from birthplace order by birthplace_id') as $row){
                    echo '<option value=',$row['birthplace_id'],'>',$row['birthplace_name'],'</option>';
                }
                ?>                 
                </select>
            </div>
            <div class="select-group">
                <label for="residence">居住地</label>
                <?
                foreach($pdo->query('select * from residence order by residence_id') as $row){
                    echo '<option value=',$row['residence_id'],'>',$row['residence_name'],'</option>';
                }
                ?>
            </div>
            <div class="form-group">
                <label for="spendHoliday">休日の過ごし方</label>
                <textarea id="message" name="message" rows="4" cols="500" class="off"></textarea>
            </div>
            <div class="checkbox-group">
                <label>
                    <input type="hidden" name="drinking" value="0">
                    <input type="checkbox" name="drinking" value="1"> 飲酒
                </label>
                <label>
                    <input type="hidden" name="smoking" value="0">
                    <input type="checkbox" name="smoking" value="1"> 喫煙
                </label>
            </div>
            <div class="form-group" id="submit_button">
                <div class="btn-container">
                    <a href="../login/login.html" class="btn">キャンセル</a>
                    <button<a href="../top/top.html" class="btn">保存</a>
                </div>
            </div>

        </form>
    </div>
</body>
</html>