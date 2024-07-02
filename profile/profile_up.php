<?php require '../header.php';?>
<?php require '../menu/menu.php';?><!--menuはbodyタグの中に絶対に入れるように -->
<title>プロフィール</title>
<link rel="stylesheet" href="profile.css/.css">
<script src="js/style.js"></script>
</head>
<!-- プロフィールを更新するためのもの -->
<body>
    <div class="main">
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
        <form action="./profile-upout.php" method="post" enctype="multipart/form-data">
            <?php
            $pdo = new PDO($connect, USER, PASS);
            $select = 'select * from user, profile where user.user_id = profile.user_id and profile.user_id = ?';
            $sql = $pdo->prepare($select);
            $user_id = $_SESSION['user']['id'];

            if (isset($_SESSION['user']['id'])) {
                $sql->execute([$user_id]);
                foreach ($sql as $user) {
                    echo <<<EOF
                    <div class="icon-section">
                        <span>アイコンの変更</span>
                        <div class="icon-container">
                            <img id="profileIcon" src="../user_image/main/{$user['icon_image']}" alt="プロフィールアイコン">
                            <label for="iconInput" class="plus" onclick="uploadIcon()">+</label>
                            <input type="file" id="iconInput" name="icon" accept="image/*" style="display: none;">
                        </div>
                    </div>

                    <p>サブ写真</p>
                    <div class="sub-images">
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer1">
                                <img id="subImage1" src="../user_image/sub/{$user['sub_a_image']}" alt="サブ写真1">
                            </div>
                            <label for="subImageInput1" class="subImagePut" onclick="uploadSubImage('subImageInput1', 'subImage1')">+</label>
                            <input type="file" id="subImageInput1" name="subImage1" accept="image/*" style="display: none;">
                        </div>
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer2">
                                <img id="subImage2" src="../user_image/sub/{$user['sub_b_image']}" alt="サブ写真2">
                            </div>
                            <label for="subImageInput2" class="subImagePut" onclick="uploadSubImage('subImageInput2', 'subImage2')">+</label>
                            <input type="file" id="subImageInput2" name="subImage2" accept="image/*" style="display: none;">
                        </div>
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer3">
                                <img id="subImage3" src="../user_image/sub/{$user['sub_c_image']}" alt="サブ写真3">
                            </div>
                            <label for="subImageInput3" class="subImagePut" onclick="uploadSubImage('subImageInput3', 'subImage3')">+</label>
                            <input type="file" id="subImageInput3" name="subImage3" accept="image/*" style="display: none;">
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="username">ユーザー名</label>
                        <input type="text" id="username" name="username" value="{$user['user_name']}">
                    </div>
                    <div class="form-group">
                        <label for="selfIntro">自己紹介</label>
                        <textarea id="selfIntro" name="selfIntro" rows="5" maxlength="500" required>{$user['introduction']}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="hobbies">趣味/特技</label>
                        <select name="category">
\n
EOF;
                        $hobby=$user['hobby_id'];
                        foreach($pdo->query('select * from hobby order by hobby_id') as $row){
                            if($hobby==$row['hobby_id']){
                                echo '<option value=',$hobby,' selected>',$row['hobby_name'],'</option>';
                            }else{
                                echo '<option value=',$row['hobby_id'],'>',$row['hobby_name'],'</option>';
                            }
                        }
                        echo '</select>';
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
                    echo <<< EOF
                    <div class="select-group">
                        <label for="age">年齢</label>
                        <input type="number" id="age" name="age" value="{$user['age']}" min="0" required>
                    </div>
                    <div class="select-group">
                        <label for="bloodType">血液型</label>
                        <select id="bloodType" name="bloodType">
\n
EOF;
                    $bloodType=$user['blood_type_id'];
                    foreach($pdo->query('select * from blood_type order by blood_type_id') as $row){
                        if($bloodType==$row['blood_type_id']){
                            echo '<option value=',$bloodType,' selected>',$row['blood_type_name'],'</option>';
                        }else{
                            echo '<option value=',$row['gender_id'],'>',$row['blood_type_name'],'</option>';
                        }
                    }
                    echo <<< EOF
                       </select>
                    </div>
                    <div class="select-group">
                    <label for="school">学校</label>
\n
EOF;
                    echo '<select id="school" name="school">';
                    $school=$user['school_id'];
                    foreach($pdo->query('select * from school order by school_id') as $row){
                        if($school==$row['school_id']){
                            echo '<option value=',$school,' selected>',$row['school_name'],'</option>';
                        }else{
                            echo '<option value=',$row['school_id'],'>',$row['school_name'],'</option>';
                        }
                    }
                    echo '</select>
                    </div>
                    <div class="select-group">
                        <label for="hometown">出身地</label>';
                        echo '<select id="hometown" name="hometown">';
                        $birthPlace=$user['birthplace_id'];
                        foreach($pdo->query('select * from birthplace order by birthplace_id') as $row){
                            if($birthPlace==$row['birthplace_id']){
                                echo '<option value=',$birthPlace,' selected>',$row['birthplace_name'],'</option>';
                            }else{
                                echo '<option value=',$row['birthplace_id'],'>',$row['birthplace_name'],'</option>';
                            }
                        }
                        echo <<< EOF
                        </select>
                    </div>
                    <div class="select-group">
                        <label for="residence">居住地</label>
\n
EOF;
                        echo '<select id="residence" name="residence">';
                        $residence=$user['residence_id'];
                        foreach($pdo->query('select * from residence order by residence_id') as $row){
                            if($residence==$row['residence_id']){
                                echo '<option value=',$residence,' selected>',$row['residence_name'],'</option>';
                            }else{
                                echo '<option value=',$row['residence_id'],'>',$row['residence_name'],'</option>';
                            }
                        }
                        echo<<<EOF
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
                    <button type="submit" class="btn" name="btn" value="submit">保存</button>
                </div>
            </div>

        </form>
    </div>
    </div>
</body>
</html>